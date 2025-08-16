<?php

namespace App\Http\Requests\Study;

use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
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
            'title' =>['required','min:5','max:40'],
            'body' => ['required','min:5','max:1000'],
            'study_book_id' => ['nullable','numeric'],
        ];
    }

}
