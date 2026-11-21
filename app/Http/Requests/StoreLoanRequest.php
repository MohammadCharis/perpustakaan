<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return ['book_id' => ['required', 'exists:books,id'], 'member_id' => ['required', 'exists:members,id']];
    }
}
