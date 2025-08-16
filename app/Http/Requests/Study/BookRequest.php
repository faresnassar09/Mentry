<?php

namespace App\Http\Requests\Study;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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

'title' => ['required','min:6','max:40','string'],
'book' => ['required','max:10240','file','mimes:pdf'],  

        ];
    }

}
    