<?php

namespace App\Http\Requests\Unlock;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Unlock;

class GetUnlockEntriesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $unlock = Unlock::findOrFail($this->unlock_id);

        // Make sure the requesting user is attached to the vault
        if ($this->user()->cannot('access', $unlock->vault)) return false;

        // Make sure the unlock is fully authorized
        if (!$unlock->isAuthorized()) return false;

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [];
    }
}
