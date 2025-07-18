<?php

namespace App\Http\Requests\Study;

use Illuminate\Foundation\Http\FormRequest;

class Note extends FormRequest
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
            'type' => ['nullable','numeric'],
        ];
    }
    public function messages()
    {
        return [ 

            'title.required' => 'يجب كتابة عنوان',
            'title.min' => 'لا يمكن ان يكون العنوان اقل من 5 احرف',
            'title.max' =>  'لا يمكن ان يكون العنوان اكثر من 40 حرف',
            'body.required' => 'اكتب تفاصيل الملاحظة',
            'body.min' => 'يجب ان تكون الملاحظة علي الاقل 5 احرف',
            'body.max' =>'لا يمكن ان يكون محتوي الملاحظة اكثر من 1000 احرف',

        ];
    }
}
