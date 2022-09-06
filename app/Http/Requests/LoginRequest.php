<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is not empty',
            'email.email' => 'Type email is not right',
            'email.unique' => 'This email is exist, please choose a new one',
            'password.required' => 'Password is not empty',
            'password.string' => 'Password is not empty'
        ];
    }
}
