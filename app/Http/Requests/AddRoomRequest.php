<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddRoomRequest extends FormRequest
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
            'hotel_id' => 'required',
            'room_title' => 'required',
            'room_type_id' => 'required',
            'room_category_id' => 'required',
            'RoomNumber' => 'required',
            'FloorNo' => 'required',
            'RoomCharges' => 'required',
            'tax_rate_id' => 'required',
            
        ];
    }
}
