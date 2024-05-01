<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostRequest extends FormRequest
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
            'title' => 'required|min:3|string',
            'content' => 'required|min:3|max:250|string',
            'user_id' => 'exists:users,id',
            'category_id' => 'exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'title.min' => 'O título deve ter no mínimo 3 caracteres.',
            'title.string' => 'O título deve ser texto.',
            'content.required' => 'O conteúdo é obrigatório.',
            'content.min' => 'O conteúdo deve ter no mínimo 3 caracteres.',
            'content.max' => 'O conteúdo deve ter no máximo 250 caracteres.'
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'error' => true,
            'message' => array_values($validator->errors()->getMessages())[0][0]
        ]));
    }
}
