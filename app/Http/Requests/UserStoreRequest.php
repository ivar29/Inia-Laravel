<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
           'name' => 'required|max:100|min:2',
           'cargo' => 'required|max:100|min:2',
           'email' => 'required|max:100|email|min:2|unique:users,email',
           'password' => 'required|max:100|min:3',
           'roles' => 'required',
       ];
     }

     public function messages(){
       return [
           'name.required' => 'El nombre del usuario esta vacío.',
           'name.max' => 'El nombre del usuario no debe contener más de 100 caracteres.',
           'name.min' => 'El nombre del usuario debe contener al menos 2 caracteres.',
           'cargo.required' => 'El cargo del usuario esta vacío.',
           'cargo.max' => 'El cargo del usuario no debe contener más de 100 caracteres.',
           'cargo.min' => 'El cargo del usuario debe contener al menos 2 caracteres.',
           'email.required' => 'El email del usuario esta vacío.',
           'email.max' => 'El email del usuario no debe contener más de 100 caracteres.',
           'email.min' => 'El email del usuario debe contener al menos 2 caracteres.',
           'email.unique' => 'El Mail ya está registrado.',
           'password.required' => 'La contraseña del usuario esta vacía.',
           'password.max' => 'La contraseña del usuario no debe contener más de 100 caracteres.',
           'password.min' => 'La contraseña del usuario debe contener al menos 3 caracteres.',
           'roles.required' => 'El rol del usuario esta vacío.',
       ];
     }
}
