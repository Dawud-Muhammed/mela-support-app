<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id'       => 'required|exists:categories,id',
            'subject'           => 'required|string|max:255',
            'description'       => 'required|string',
            'building'          => 'required|string',
            'floor'             => 'required|string',
            'specific_location' => 'required|string',
            'evidence'          => 'required|image|mimes:jpeg,png,jpg,pdf|max:10240',
        ];
    }
}
