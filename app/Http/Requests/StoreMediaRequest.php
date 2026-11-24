<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'   => 'required|string|max:255|unique:media,title',
            'type'    => 'required|string|max:100',
            'genre'   => 'required|string|max:150',
            'rating'  => 'nullable|numeric|min:0|max:10',
            'summary' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul media wajib diisi.',
            'title.unique'   => 'Judul media sudah terdaftar di FlipPlay.',
            'type.required'  => 'Jenis media (Anime/Drama/Series) wajib diisi.',
            'genre.required' => 'Genre media wajib diisi.',
            'rating.max'     => 'Rating maksimal adalah 10.',
        ];
    }
}
