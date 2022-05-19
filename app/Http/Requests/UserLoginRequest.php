<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'email' => 'required|email',
            'password' => 'required'
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
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
    
    /**
     * Summary of messages
     * @return array<string>
     */
    
    public function messages()
    {
        return [          
            'email.required' => 'Email is required',
            'email.email' => 'Email must be valid.',
            'password.required' => 'Password is required.',
        ];
    }

}
