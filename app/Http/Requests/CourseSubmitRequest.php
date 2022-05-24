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
            'name' => 'required|max:50',
            'course_cover_path' => 'required|mimes:jpg,jpeg|max:2000',
            'video_path' => 'required',
            'video_path.*' => 'required|mimes:mp4|max:20000',
            'category_id' => 'required|numeric',
            'short_descrip' => 'required|max:100',
            'description' => 'required|max:200',
            'instructor' => 'required|max:50',
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
            'name.max' => 'Name must not be more than 50 characters.',
            'course_cover_path.required' => 'Your image is required',
            'course_cover_path.mimes' => 'Your image must be JPG or JPEG format.',
            'course_cover_path.max' => 'Your image is more than 2MB.',
            'video_path.*.required' => 'Your videos is required',
            'video_path.*.mimes' => 'Your videos must be MP4 format.',
            'video_path.*.max' => 'Your videos is more than 20MB.',
            'category_id.required' => 'Category is required.',
            'short_descrip.required' => 'Short_Description is required.',
            'short_descrip.max' => 'Short_Description must not be more than 100 characters.',
            'description.required' => 'Description is required',
            'description.max' => 'Description must not be more than 200 characters.',
            'instructor.required' => 'Instructor is required.',
            'instructor.max' => 'Instructor must not be more than 50 characters.',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be numberic.'
        ];
    }
    
}
