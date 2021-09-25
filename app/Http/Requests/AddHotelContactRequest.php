<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddHotelContactRequest extends FormRequest
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
            'contact.hotel_id' => 'required',
            'contact.contact_type_id' =>  'required',
            'contact.Value' => 'required',
            'contact.ContactPerson' => 'required'
        ];
    }
}
