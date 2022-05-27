<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|mimes:xlsx'
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
        ], 401));
    }

    /**
     * Summary of messages
     * @return array<string>
     */

    public function messages()
    {
        return [
            'file.required' => 'file is required',
            'file.mimes' => 'File must be excel format',
        ];
    }
}
