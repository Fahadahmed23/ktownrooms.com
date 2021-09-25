<?php
namespace App\Http\Requests\Admin;

use App\Http\Requests\Request as Request;

class AddPermissionRequest extends Request {

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
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //'email.unique'    => 'Email already found in our system, please try another one.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'name'  => 'required|string',
            'display_name'  => 'required|string',
          
        ];

        return $rules;
    }
}