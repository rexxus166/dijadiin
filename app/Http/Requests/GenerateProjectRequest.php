<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateProjectRequest extends FormRequest
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
            'project_name' => ['required', 'string', 'max:255', 'alpha_dash'],
            'description'  => ['nullable', 'string', 'max:1000'],
            'db_type'      => ['required', 'string', 'in:mysql,pgsql,sqlite'],
            'db_port'      => ['nullable', 'string', 'max:5'], // Optional custom port
            'db_name'      => ['required_unless:db_type,sqlite', 'string', 'max:255'],
            'db_username'  => ['required_unless:db_type,sqlite', 'string', 'max:255'],
            'db_password'  => ['nullable', 'string', 'max:255'],
            'ai_prompt'    => ['nullable', 'string'], // Gemini context prompt
        ];
    }
}
