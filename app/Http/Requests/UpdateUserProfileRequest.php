<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "first_name"=>"required|string",
            "last_name"=>"required|string",
            "address"=>"required|string",
            "telephone"=>"required|string",
            "birth_date"=>"required|date",
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    
        ];
    }
}
