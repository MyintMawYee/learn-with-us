<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CourseSubmitRequest extends FormRequest
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
            'course_cover_path' => 'required|mimes:jpg,jpeg|max:2000',
            'video_path' => 'required',
            'video_path.*' => 'required|mimes:mp4',
            'category_id' => 'required|numeric',
            'short_descrip' => 'required',
            'description' => 'required',
            'instructor' => 'required',
            'price' => 'required|numeric'
        ];
    }

    /**
     * Summary of failedAuthorization
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
            'name.required' => 'Name is required',
            'course_cover_path.required' => 'Your image is required',
            'course_cover_path.mimes' => 'Your image must be JPG or JPEG format.',
            'course_cover_path.max' => 'Your image is more than 2MB.',
            'video_path.*.required' => 'Your videos is required',
            'video_path.*.mimes' => 'Your videos must be MP4 format.',
            'video_path.*.max' => 'Your videos is more than 10MB.',
            'category_id.required' => 'Category is required.',
            'short_descrip.required' => 'Short_Description is required.',
            'description.required' => 'Description is required',
            'instructor.required' => 'Instructor is required.',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be numberic.'
        ];
    }
    
}
