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
        $role_rule = Rule::in(config('const.roleAdmin'), config('const.roleGeneral'));

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:filter,rfc|max:255|unique:users,email,' . $this->user()->id,
            'password' => 'nullable|string|min:8|regex:/^[a-zA-Z0-9!@#%^&*]+$/|confirmed',
            'password_confirm' => 'required_with:password|nullable|string|min:8|regex:/^[a-zA-Z0-9!@#%^&*]+$/',
            'current_password' => 'required|string|min:8|regex:/^[a-zA-Z0-9!@#%^&*]+$/',
            'role' => 'integer|' . $role_rule
        ];
    }
}
