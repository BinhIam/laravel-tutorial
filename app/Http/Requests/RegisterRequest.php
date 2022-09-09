<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
        $emailValidation = auth()->user() ? 'required|email' : 'required|email|unique:users';
        return [
            'name' => 'required|max:50',
            'email' => $emailValidation,
            'password' => 'required|string'
        ];
    }

    /**
     * Get the validation message that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is not empty',
            'name.max' => 'Name character maximum is 50',
            'email.required' => 'Email is not empty',
            'email.email' => 'Type email is not right',
            'email.unique' => 'This email is exist, please choose a new one',
            'password.required' => 'Password is not empty',
            'password.string' => 'Password is not empty'
        ];
    }
}
