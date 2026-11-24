<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateMediaRequest extends FormRequest
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
     * @return array<string, Rule|array<mixed>|string>
     */
    public function rules(): array
    {
        $mediaId = $this->route('media')?->id ?? $this->route('media');

        return [
            'title'   => ['sometimes', 'required', 'string', 'max:255', Rule::unique('media', 'title')->ignore($mediaId)],
            'type'    => 'sometimes|required|string|max:100',
            'genre'   => 'sometimes|required|string|max:150',
            'rating'  => 'sometimes|nullable|numeric|min:0|max:10',
            'summary' => 'sometimes|nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul media tidak boleh dikosongkan.',
            'title.unique'   => 'Judul media tersebut sudah digunakan oleh media lain.',
            'type.required'  => 'Jenis media tidak boleh kosong.',
            'genre.required' => 'Genre media tidak boleh kosong.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'  => 'error',
            'message' => 'Validasi pembaruan data gagal.',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
