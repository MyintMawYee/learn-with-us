<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Lang;

class UserLoginRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
        ];
    }

     /**
      * Summary of failedValidation
      * @param Validator $validator
      * @return void
      */

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'result' => 0,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ],401));
    }
    
    /**
     * Summary of messages
     * @return array<string>
     */

    public function messages()
    {
        return [          
            'email.required' => 'Email is required',
            'email.exists' => Lang::get("messages.loginsuccess.wrongemail"),
            'email.email' => 'Email must be valid.',
            'password.required' => 'Password is required.',
            'password.min' => 'Your password must be mininum 8 characters long.',
            'password.regex' => 'Your password should contain at-least 1 Uppercase, 1 Lowercase, 1 Numberic and 1 Special character',
        ];
    }

}
