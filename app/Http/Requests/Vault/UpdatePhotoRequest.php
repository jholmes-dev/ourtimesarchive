<?php

namespace App\Http\Requests\Vault;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Vault;

class UpdatePhotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $vault = Vault::find($this->route('id'));
        return $vault && $this->user()->can('access', $vault);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'vault_photo' => 'required|image|max:20971'
        ];
    }
}
