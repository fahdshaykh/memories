<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
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
            'slug' => 'required|string|max:255|unique:galleries,slug', // Unique validation for the slug
            'content' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:max_width=1400,max_height=1000',
            'status' => '1',
        ];
    }
}
