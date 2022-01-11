<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditUser extends FormRequest
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
        $admin_num = 1;
        $general_user_num = 10;
        $role_rule = Rule::in($admin_num, $general_user_num);
        
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:filter,rfc|max:255|unique:users,email,'.$this->user()->id,
            'password' => 'nullable|string|min:8|regex:/^[a-zA-Z0-9]+$/|confirmed',
            'current_password' => 'required|string|min:8|regex:/^[a-zA-Z0-9]+$/',
            'role' => 'integer|'.$role_rule
        ];
    }
}
