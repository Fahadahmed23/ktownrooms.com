<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddHotelRequest extends FormRequest
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
            'hotel.HotelName' => 'required',
            'hotel.company_id' => 'required',
            'hotel.city_id' => 'required',
            'hotel.Address' => 'required',
            'hotel.ZipCode' => 'required',
            'hotel.Latitude' => 'required',
            'hotel.Longitude' => 'required'
        ];
    }
}
