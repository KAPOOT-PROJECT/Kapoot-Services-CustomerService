<?php

namespace App\Http\Requests;

use App\Rules\NationalIdRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
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
            'first_name'    => 'required|string|min:3|max:25',
            'last_name'     => 'required|string|min:3|max:25',
            'national_id'   => ['required', 'numeric', new NationalIdRule()],
            'date_of_birth' => 'nullable|date',
            'preferences'   => 'nullable',
        ];
    }
}
