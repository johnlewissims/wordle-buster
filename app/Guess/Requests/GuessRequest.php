<?php

namespace App\Guess\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'guess' => 'required|array',
            'guess.*' => 'required|array',
            'guess.*.*' => 'required|array',
            'guess.*.*.value' => 'required|string|size:1',
            'guess.*.*.result' => 'required|integer|in:1,2,3',
            'guess.*.*.alert' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'guess.required' => 'Guess data is required',
            'guess.*.*.value.required' => 'Each letter must have a value',
            'guess.*.*.value.size' => 'Each letter value must be a single character',
            'guess.*.*.result.required' => 'Each letter must have a result',
            'guess.*.*.result.in' => 'Result must be 1 (correct), 2 (incorrect), or 3 (incorrect position)',
            'guess.*.*.alert.required' => 'Each letter must have an alert status',
            'guess.*.*.alert.boolean' => 'Alert status must be true or false',
        ];
    }

    public function getGuessData(): array
    {
        return $this->validated()['guess'];
    }
}
