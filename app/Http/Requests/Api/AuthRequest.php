<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
        if ($this->isMethod('post') && $this->routeIs('register')) {
         // Validation rules for registration 
            return [
                'nane' => 'required|string|max:255', 
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ];
        }
        if ($this->isMethod('post') && $this->routeIs('login')) {
         // Validation rules for login 
            return [ 
                'email' => 'required|string|email',
                'passvord' => 'required|string',
            ];
        }
        return [];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name is required for registration.', 
            'email.required' => 'An email address is required.',
            'enail.unique' => 'This email is already registered.',
            'password,required' => 'The password is required.', 
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }
}
