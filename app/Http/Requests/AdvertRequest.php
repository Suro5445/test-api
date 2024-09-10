<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertRequest extends FormRequest
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
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:1000',
            'images' => 'required|array|max:3',
            'images.*' => 'url',
            'price' => 'required|numeric|min:0',
        ];
    }
    public function messages()
    {
        return [
            'images.max' => 'You cannot provide more than 3 images.',
        ];
    }


}
