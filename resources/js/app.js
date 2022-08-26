import './bootstrap';
import '../css/app.css';
import jQuery from 'jquery';

window.$ = jQuery;

$(document).ready(function () {
    var timeTracker = null;
    var timerText = null;
    var projectName = '';
    var projectDate = null;
    var projectStartTime = null;
    var projectEndTime = null;
    var time = {
        hour: 0,
        minute: 0,
        second: 0
    };

    $.ajaxSetup({
        headers:
            {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    $('.start').on('click', function (e) {
        e.preventDefault();
        projectName = $('input[type="text"]').val();

        if ('' !== projectName) {
            $(this).hide();
            $('input[type="text"]').prop('disabled', true);
            $('.stop').show();
            $('.timer-project-name').text($('input[type="text"]').val());
            projectStartTime = getDateOrTime('time');
            createTimeTracker();
        }
    });

    $('.stop').on('click', function (e) {
        e.preventDefault();
        projectEndTime = getDateOrTime('time');
        projectDate = getDateOrTime('date');
        var uuid = generateNewUuid();

        $.ajax({
            url: "time-tracker/" + uuid,
            method: "PUT",
            contentType: "application/json",
            data: JSON.stringify({
                name: projectName,
                date: projectDate,
                starts_at_time: projectStartTime,
                ends_at_time: projectEndTime
            }),
            success: function (data, textStatus, jqXHR) {
                location.reload(true);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('error');
            }
        });
    });

    function getDateOrTime(type) {
        var today = new Date();

        switch (type) {
            case 'time':
                var result = ('0' + today.getHours()).substr(-2) + ':' + ('0' + today.getMinutes()).substr(-2) + ':' + ('0' + today.getSeconds()).substr(-2);
                break;
            case 'date':
                var result = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).substr(-2) + '-' + ('0' + today.getDate()).
                substr(-2);
                break;
        }

        return result;
    }

    function generateNewUuid() {
        var dt = new Date().getTime();
        var newUuid = 'xxxxxxxx-xxxx-xxxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            var r = (dt + Math.random() * 16) % 16 | 0;
            dt = Math.floor(dt / 16);
            return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
        });

        return newUuid;
    }

    function createTimeTracker() {
        timeTracker = setInterval(function () {
            // Seconds
            time.second++;
            if (time.second >= 60) {
                time.second = 0;
                time.minute++;
            }

            // Minutes
            if (time.minute >= 60) {
                time.minute = 0;
                time.hour++;
            }

            timerText = time.hour < 10 ? '0' + time.hour + ':' : time.hour + ':';
            timerText += time.minute < 10 ? '0' + time.minute + ':' : time.minute + ':';
            timerText += time.second < 10 ? '0' + time.second : time.second;
            $('.timer-text').text(timerText);
        }, 1000);
    }
});
