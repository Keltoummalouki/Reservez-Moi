<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'is_available' => 'boolean',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'Le nom du service est obligatoire.',
            'price.required' => 'Le prix du service est obligatoire.',
            'price.min' => 'Le prix ne peut pas être négatif.',
        ];
    }
}