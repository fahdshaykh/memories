<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id'   => 'required',
            'title' => 'required|min:4|max:255',
            'slug' => 'required|string|max:255|unique:videos,slug', // Unique validation for the slug
            'content' => 'nullable',
            'video_file' => 'required|mimes:mp4,avi,mov,mkv,wmv,flv|max:102400',
        ];
    }
}
