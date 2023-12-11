<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class checkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'body' => 'required|string',
        ];
    }
}
