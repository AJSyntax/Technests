<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'template_id' => 'sometimes|required|exists:templates,id',
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'phone' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'github_username' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url',
            'is_public' => 'boolean',
            'profile_picture' => 'nullable|image|max:2048', // Max 2MB
        ];
    }
} 