<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreFactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->isAdmin();
    }

    /**
     * @return array<string, list<int|string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'teaser' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'cardsTeaser' => ['nullable', 'string'],
            'actionTeaser' => ['nullable', 'string'],
            'actionList' => ['nullable', 'string'],
            'actions' => ['nullable', 'string'],
            'characters' => ['nullable', 'string'],
            'bases' => ['nullable', 'string'],
            'clarifications' => ['nullable', 'string'],
            'suggestionTeaser' => ['nullable', 'string'],
            'synergy' => ['nullable', 'string'],
            'tips' => ['nullable', 'string'],
            'mechanics' => ['nullable', 'string'],
            'expansion' => ['nullable', 'string', 'max:255'],
            'effects' => ['nullable', 'string'],
            'playstyle' => ['nullable', 'string'],
        ];
    }
}
