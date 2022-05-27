<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
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
            'name.required' => 'User name cannot  blank',     
            'email.required' => 'Email cannot  blank',
            'email.email' => 'Email format is invalid',
            'password.required' => 'Password cannot blank',
            'password.min' => 'Password min length is 8 character',
            'password.regex' => 'Your password should contain at-least 1 Uppercase, 1 Lowercase, 1 Numberic and 1 Special character',  
        ];
    }
}