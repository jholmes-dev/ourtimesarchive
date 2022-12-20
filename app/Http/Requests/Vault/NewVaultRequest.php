<?php

namespace App\Http\Requests\Vault;

use Illuminate\Foundation\Http\FormRequest;

class NewVaultRequest extends FormRequest
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
            'vault_name' => 'required|max:255|String',
            'invites' => 'array|max:9',
            'invites.*' => 'email|max:255|nullable'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'invites.*.email' => 'Invitations must be valid email addresses',
            'invites.*.max' => 'Invitation email addresses cannot exceed 255 characters'
        ];
    }
}
