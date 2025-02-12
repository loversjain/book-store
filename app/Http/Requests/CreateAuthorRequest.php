<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class CreateAuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Allow all users to create authors, modify as needed for permissions
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday' => 'required|date|before:' . Carbon::now()->subYears(18)->toDateString(),
            'biography' => 'required|string',
            'gender' => 'required|string|in:male,female',
            'place_of_birth' => 'required|string|max:255',
        ];
    }
}
