<?php

namespace App\Http\Requests\Study;

use Illuminate\Foundation\Http\FormRequest;

class Material extends FormRequest
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
            
            'title' => ['required','min:5','max:40','string'],
            'file' => ['required','max:15360','mimes:pdf,jpg,jpge,png'],
            'type' => ['nullable','min:1','max:2','numeric'],
            
        ];
    }
}
