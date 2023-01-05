<?php

namespace App\Http\Requests\Entry;

use Illuminate\Foundation\Http\FormRequest;

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
            'entry_title' => 'string|max:255',
            'entry_date' => 'required|date',
            'entry_address' => 'string|max:1024',
            'entry_content' => 'string|max:10000',
            'images' => 'array|max:9',
            'images.*' => 'image'
        ];
    }
}
