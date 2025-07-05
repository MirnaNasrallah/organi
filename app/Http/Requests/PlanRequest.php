<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasVerifiedEmail();
        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'goal' => 'required|string|in:lose,gain,maintain',
            'activity_level' => 'required|string|in:sedentary,lightly_active,moderately_active,very_active',
            'calories_target' => 'required|numeric|min:1000|max:5000',
        ];
    }
}
