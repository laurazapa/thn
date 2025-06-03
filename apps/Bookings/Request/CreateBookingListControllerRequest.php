<?php

declare(strict_types=1);

namespace Apps\Bookings\Request;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request class for handling booking list creation.
 * 
 * This class validates the incoming HTTP request for creating multiple bookings.
 * It ensures that all required booking data is present and properly formatted
 * before the request is processed by the controller.
 * 
 * The validation rules ensure:
 * 1. The bookings array exists and is not empty
 * 2. Each booking has all required fields (userId, roomId, checkInDate, checkOutDate)
 * 3. All IDs are valid UUIDs
 * 4. Dates are in a valid format
 */
class CreateBookingListControllerRequest extends FormRequest
{
    /**
     * Defines the validation rules for the booking list creation request.
     * 
     * The rules validate:
     * - The presence and structure of the bookings array
     * - The format and presence of each booking's required fields
     * - The data types and formats of all fields
     * 
     * @return array<string, array<int, string>> The validation rules
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
