<?php

namespace App\Http\Requests\Study;

use Illuminate\Foundation\Http\FormRequest;

class Book extends FormRequest
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
'book' => ['required','max:50600','mimes:pdf'],  

        ];
    }

    public function messages()
    {
        return [

            'title.min' => 'يجب ان يكون العنوان اكثر من 5 احرف',
            'title.max' => 'لايجب ان يتخطي العنوان 40 حرف',
            'title.string' => ' يجب ان يكون العنوان احرف وليس به رموز',
            'title.required' => 'العنوان مطلوب',
            'book.required' => 'لم تقم باختيار كتاب',
            'book.max' => 'الحد الاقصي لحجم الكتاب يجب ان لا يتجاوز 50 ميجا بايت',
            'book.mimes' => 'بجب ا ن يكون اللكتاب pdf',  

        ];
    }     
}
    