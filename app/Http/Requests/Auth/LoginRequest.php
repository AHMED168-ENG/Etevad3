<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required",
            "email" => "required",
            "password" => "required|min:10",
        ];
    }
    public function messages()
    {
        return [
            "name.required" => "ادخل اسم المستخدم",
            "email.required" => "ادخل ايميل المستخدم",
            "password.required" =>  "ادخل الرقم السري",
            "password.min" =>  "يجب ادخال 10 ارقام علي الاقل",
        ];
    }
}
