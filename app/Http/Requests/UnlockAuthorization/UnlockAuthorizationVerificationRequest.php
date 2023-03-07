<?php

namespace App\Http\Requests\UnlockAuthorization;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\UnlockAuthorization;

class UnlockAuthorizationVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $uAuth = UnlockAuthorization::find($this->uaid);

        // Make sure the requesting user is attached to the vault
        if ($this->user()->cannot('access', $uAuth->unlock->vault)) return false;

        // Test for the user/auth request relationship
        return $uAuth->user_id == $this->uid;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'uaid' => ['required', 'integer', 'exists:App\Models\UnlockAuthorization,id'],
            'uid' => ['required', 'integer', 'exists:App\Models\User,id'],
            'password' => ['required', 'string']
        ];
    }
}
