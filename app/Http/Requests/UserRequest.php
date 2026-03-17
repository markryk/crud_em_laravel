<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        $user = $this->route('user');

        return [
            'name' => 'required', 
            'email' => 'required|email|unique:users,email,'.($user ? $user->id : null), 
            'password' => 'required_if: password, !=, null |min:6'
        ];
    }

    public function messages(): array {
        return [
            'name.required' => "Campo nome é obrigatório!", 
            'email.required' => "Campo email é obrigatório!", 
            'email.email' => "Necessário enviar email válido!", 
            'email.unique' => "O email já está cadastrado!",
            'password.required' => "Campo senha é obrigatório!", 
            'password.min' => "Senha com no mínimo :min caracteres!"
        ];
    }
}
