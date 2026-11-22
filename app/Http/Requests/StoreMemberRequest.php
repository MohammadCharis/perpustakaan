<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'member_code' => ['required', 'string', 'max:30', 'unique:members,member_code,'.$this->route('member')?->id],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:members,email,'.$this->route('member')?->id],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
            'joined_at' => ['nullable', 'date'],
            'is_active' => ['boolean'],
        ];
    }
}
