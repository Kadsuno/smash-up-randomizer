<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Maps validated admin faction form input to deck attributes (incl. derived image URL).
 */
class FactionRequestAttributes
{
    /**
     * @param  array<string, mixed>  $validated  Output of FormRequest::validated()
     * @return array<string, mixed>
     */
    public static function payload(array $validated, string $imageBaseName): array
    {
        $baseUrl = rtrim((string) config('app.url'), '/');
        $imageUrl = $baseUrl.'/images/factions/'.strtolower($imageBaseName).'.png';

        return [
            'name' => $validated['name'],
            'image' => $imageUrl,
            'teaser' => $validated['teaser'] ?? null,
            'description' => $validated['description'] ?? null,
            'cardsTeaser' => $validated['cardsTeaser'] ?? null,
            'actionTeaser' => $validated['actionTeaser'] ?? null,
            'actionList' => $validated['actionList'] ?? null,
            'actions' => $validated['actions'] ?? null,
            'characters' => $validated['characters'] ?? null,
            'bases' => $validated['bases'] ?? null,
            'clarifications' => $validated['clarifications'] ?? null,
            'suggestionTeaser' => $validated['suggestionTeaser'] ?? null,
            'synergy' => $validated['synergy'] ?? null,
            'tips' => $validated['tips'] ?? null,
            'mechanics' => $validated['mechanics'] ?? null,
            'expansion' => $validated['expansion'] ?? null,
            'effects' => $validated['effects'] ?? null,
            'playstyle' => $validated['playstyle'] ?? null,
        ];
    }
}
