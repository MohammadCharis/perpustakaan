<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['category_id' => ['required', 'exists:categories,id'], 'isbn' => ['required', 'string', 'max:30', 'unique:books,isbn,'.$this->route('book')?->id], 'title' => ['required', 'string', 'max:255'], 'author' => ['required', 'string', 'max:255'], 'published_year' => ['nullable', 'integer', 'between:1000,2100'], 'stock' => ['required', 'integer', 'min:0'], 'description' => ['nullable', 'string']];
    }
}
