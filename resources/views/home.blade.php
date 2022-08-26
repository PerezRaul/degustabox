@extends('layouts.master')

@section('content')
    <div class="row">
        <h1>Time Tracker</h1>
    </div>
    <div class="row">
        <div class="column">
            <form class="project-form">
                <input type="text" name="project" placeholder="Enter project name">
                <ul class="projects">
                    <li>
                        <h2 class="timer-project-name"></h2>
                        <div class="timer">
                            <p class="timer-label">Total Time Spent</p>
                            <p class="timer-text"><span>00:00:00</span></p>
                        </div>
                        <button class="btn start">Start</button>
                        <button class="btn stop">Stop</button>
                    </li>
                </ul>
            </form>
        </div>
        <div class="column">
            <table class="styled-table">
                <thead>
                <tr>
                    <th>Project name</th>
                    <th>Date</th>
                    <th>Spent Time</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $totalSpentTime = null;
                    @endphp
                    @foreach ($timeTracker['data'] as $data)
                        <tr>
                            <td>{{ $data['name'] }}</td>
                            <td>{{ $data['timestamp']['date'] }}</td>
                            <td>{{ $data['timestamp']['time_spent'] }}</td>
                            @php
                                $totalSpentTime += strtotime($data['timestamp']['time_spent']);
                            @endphp
                        </tr>
                    @endforeach
                    <tr>
                        <td class="column-center" colspan="5"><b>Total worked today:</b> {{ (null === $totalSpentTime) ? '00:00:00' : date('H:i:s', $totalSpentTime) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
