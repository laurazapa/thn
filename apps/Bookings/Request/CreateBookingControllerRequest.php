<?php

declare(strict_types=1);

namespace Apps\Bookings\Request;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookingControllerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'bookings' => ['required', 'array', 'min:1'],

            'bookings.*.userId' => ['required', 'string', 'uuid'],
            'bookings.*.roomId' => ['required', 'string', 'uuid'],
            'bookings.*.checkInDate' => ['required', 'date'],
            'bookings.*.checkOutDate' => ['required', 'date'],
        ];
    }
}
