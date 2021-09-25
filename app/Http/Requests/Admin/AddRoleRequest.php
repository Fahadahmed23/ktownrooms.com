<?php
namespace App\Http\Requests\Admin;

use App\Http\Requests\Request as Request;

class AddRoleRequest extends Request {

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
            'name.required'    => 'The role name field is required.',
            'name.unique'    => 'The role name has already been taken.',
            'preference.unique' => 'This preference number already exists',
            'preference.min' => 'Preference cannot be negative'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // dd($this->all());
        $a = false;
        if(isset($this->permissions)){
            $a = in_array('true',$this->permissions);
        }
        $rules = [
            'name'  => "required|unique:roles,name,{$this->id},id",
            'display_name'  => 'required',
            'permissions' => 'sometimes|nullable'
            // 'preference' => "required|numeric|min:0|unique:roles,preference,{$this->id},id",
        ];
        if ($a) {
            // $rules['landing_page'] =  "required_with:permissions";
        }
        return $rules;
    }
}