<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
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
            'title'       => 'required|string|max:255',
            'slug'        => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\-]+$/',
                Rule::unique('posts', 'slug'), // SIRF YEHI — KOI DELETED_AT NAHI!
            ],
            'content'     => 'required',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5048',
            'tags'        => 'nullable|string',
            'quote.*'     => 'nullable|string',
        ];
    }
}
