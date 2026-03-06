<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVideoRequest extends FormRequest
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
            'category_id' => ['nullable', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('videos', 'slug')->ignore($this->route('video')),
            ],
            'content' => ['nullable', 'string'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,avi,mov,mkv,wmv,flv', 'max:102400'],
            'status' => ['nullable', 'boolean'],
        ];
    }
}
