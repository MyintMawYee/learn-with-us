<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PasswordChangeRequest extends FormRequest
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
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password'
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
          ],400));
      }
      
      /**
       * Summary of messages
       * @return array<string>
       */
  
      public function messages()
      {
          return [          
              'old_password.required' => 'Old Password is required',
              'new_password.required' => 'New Password is required',
              'new_password.min' => 'Password min length is 8 character',
              'confirm_password.required' => 'Confirm Password is required',
              'confirm_password.min' => 'Password min length is 8 character',
              'confirm_password.same' => 'Password does not match',
            ];
      }
}
