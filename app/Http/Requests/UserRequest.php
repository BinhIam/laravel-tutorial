<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $emailValidation = auth()->user() ? 'required|email' : 'required|email|unique:users';
        return [
            'name' => 'required|max:50',
            'age' => 'required|numeric',
            'class_id' => 'required|numeric',
            'email' => $emailValidation,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is not empty',
            'name.max' => 'Name character maximum is 50',
            'age.required' => 'Age is not empty',
            'age.numeric' => 'Age required number',
            'class_id.required' => 'Classes is not empty',
            'class_id.max' => 'Classes character maximum is 250',
            'email.required' => 'Email is not empty',
            'email.email' => 'Type email is not right',
            'email.unique' => 'This email is exist, please choose a new one',
        ];
    }
}
