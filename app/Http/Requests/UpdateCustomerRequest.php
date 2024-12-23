<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:50'],
            'kana'=>['required','regex:/\A[ァ-ヴー\s ]+\z/u'],        
            'tel' => ['required', 'digits:11'],
            'email' => ['required', 'max:50','email'],
            'postcode' => ['required','numeric','digits:7'],
            'birthday' => ['required', 'date'],
            'gender' => ['required'],
            'memo' => ['nullable'],
        ];
    }
}
