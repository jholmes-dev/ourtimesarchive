<?php

namespace App\Http\Requests\Entry;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Vault;

class NewEntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $vault = Vault::find($this->input('vault_id'));
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
            'vault_id' => 'required|integer',
            'entry_date' => 'required|date',
            'entry_title' => 'nullable|string|max:256',
            'entry_address' => 'nullable|string|max:1024',
            'entry_content' => 'nullable|string|max:10240',
            'images' => 'nullable|array|max:6'
        ];
    }
}
