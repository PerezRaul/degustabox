<?php

declare(strict_types=1);

namespace App\Http\Requests\TimeTrackers;

use App\Http\Requests\FormRequest;

final class TimeTrackerPutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'           => 'required|string',
            'date'           => 'required|date_format:Y-m-d',
            'starts_at_time' => 'required|date_format:H:i:s',
            'ends_at_time'   => 'present|nullable|date_format:H:i:s',
        ];
    }
}
