<?php

namespace App\Http\Requests;

use App\Http\Requests\Request as Request;

class AddUserRequest extends Request
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

    public function messages() {
        return [
            'experiences.required' => 'Experiences are required',
            'experiences.*.organization_name.required' => 'Organization Name for experience is required',
            'experiences.*.role.required' => 'Role for experience is required',
            'experiences.*.no_of_years.required' => 'No. of years in experience is required',
            'experiences.*.organization_name.alpha' => 'Organization Name for experience should only contain letters',
            'experiences.*.role.alpha' => 'Role for experience should only contain letters',
            'experiences.*.no_of_years.numeric' => 'No. of years in experience should be a number'
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
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => "required|email|unique:users,email,{$this->id},id",
            'phone_no' => 'required',
        ];


        if ($this->refType == 'Yes') {
            $rules['reference_name'] = 'required|max:50';
            $rules['reference_department'] = 'required|max:50';
            $rules['reference_designation'] = 'required|max:50';
        }

        if ($this->expType == 'Yes') {
                $rules['experiences'] = 'required';
                $rules['experiences.*.no_of_years'] = 'required|numeric';
                $rules['experiences.*.organization_name'] = 'required';
                $rules['experiences.*.role'] = 'required';
        }

        // dd($this->all());

        return $rules;
    }
}
