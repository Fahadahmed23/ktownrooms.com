<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'booking.customer.FirstName' => 'required',
            // 'booking.customer.LastName' => 'required',
            // 'booking.customer.Email' => 'required',
            'booking.customer.Phone' => 'required'
        ];
    }
}
