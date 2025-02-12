<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Update this as needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'author_id' => 'required|integer',
            'release_date' => 'required|date|before_or_equal:today',
            'description' => 'required|string',
            'isbn' => 'required|string|max:255',
            'format' => 'required|string',
            'number_of_pages' => 'required|integer',
        ];
    }
}
