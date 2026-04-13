<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Thin HTTP wrapper around AI chat-completion providers for text rewriting.
 *
 * Supported providers (configured via AI_REWRITE_PROVIDER in .env):
 *   - "groq"   → Groq API (free tier at console.groq.com, OpenAI-compatible endpoint)
 *   - "gemini" → Google Gemini API (free tier at aistudio.google.com)
 *
 * Both providers are configured via:
 *   AI_REWRITE_PROVIDER  groq | gemini
 *   AI_REWRITE_KEY       API key
 *   AI_REWRITE_MODEL     e.g. llama-3.3-70b-versatile (groq) or gemini-1.5-flash (gemini)
 */
class AiRewriteService
{
    private const GROQ_API   = 'https://api.groq.com/openai/v1/chat/completions';
    private const GEMINI_API = 'https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent';

    private string $provider;
    private string $key;
    private string $model;

    public function __construct()
    {
        $this->provider = (string) config('services.ai_rewrite.provider', 'groq');
        $this->key      = (string) config('services.ai_rewrite.key', '');
        $this->model    = (string) config('services.ai_rewrite.model', 'llama-3.3-70b-versatile');
    }

    /**
     * Rewrite a single text field for a given faction.
     *
     * @param  string  $factionName  e.g. "Aliens"
     * @param  string  $expansion    e.g. "Core Set"
     * @param  string  $field        e.g. "description"
     * @param  string  $original     The original wiki-scraped text to rewrite
     * @return string                The rewritten text
     *
     * @throws RuntimeException when the provider is misconfigured or the request fails
     */
    public function rewrite(string $factionName, string $expansion, string $field, string $original): string
    {
        $prompt = $this->buildPrompt($factionName, $expansion, $field, $original);

        return match ($this->provider) {
            'groq'   => $this->callGroq($prompt),
            'gemini' => $this->callGemini($prompt),
            default  => throw new RuntimeException("Unknown AI provider: {$this->provider}"),
        };
    }

    /**
     * Check whether an API key has been configured.
     */
    public function isConfigured(): bool
    {
        return $this->key !== '';
    }

    /**
     * Return the active provider name for display purposes.
     */
    public function providerName(): string
    {
        return $this->provider;
    }

    // -------------------------------------------------------------------------
    // Prompt
    // -------------------------------------------------------------------------

    /**
     * Build a field-aware system + user prompt pair.
     *
     * The system prompt sets a strict "only return the text, no preamble" rule.
     * The user prompt provides context (faction, field type) and the original text.
     */
    private function buildPrompt(string $faction, string $expansion, string $field, string $original): string
    {
        $fieldContext = match ($field) {
            'description'    => 'a brief introductory description of the faction for a card game randomizer app',
            'effects'        => 'a description of the faction\'s core mechanics in a competitive card game',
            'cardsTeaser'    => 'a short overview of the faction\'s card composition (minions and actions count and highlights)',
            'actionTeaser'   => 'a one- or two-sentence intro summarising the types of actions the faction uses',
            'tips'           => 'strategic gameplay tips for using this faction effectively',
            'synergy'        => 'recommendations for which other factions pair well with this one, and why',
            'suggestionTeaser' => 'a single-sentence teaser highlighting the best faction pairing',
            default          => 'a descriptive text about the faction for a card game app',
        };

        $lines = [
            "Faction: {$faction} (from the \"{$expansion}\" expansion of the Smash Up card game)",
            "Field type: {$fieldContext}",
            '',
            'Original text:',
            '"""',
            trim($original),
            '"""',
            '',
            'Instructions:',
            '- Rewrite the text entirely in your own words.',
            '- Keep all factual information (card names, power values, game mechanics) accurate.',
            '- Do not add information that is not in the original.',
            '- Keep approximately the same length and detail level.',
            '- Write in English.',
            '- Return only the rewritten text — no preamble, no explanation, no quotes.',
        ];

        return implode("\n", $lines);
    }

    // -------------------------------------------------------------------------
    // Providers
    // -------------------------------------------------------------------------

    /**
     * Send the prompt to the Groq API (OpenAI-compatible chat/completions endpoint).
     */
    private function callGroq(string $prompt): string
    {
        $response = Http::withToken($this->key)
            ->timeout(30)
            ->post(self::GROQ_API, [
                'model'       => $this->model,
                'messages'    => [
                    [
                        'role'    => 'system',
                        'content' => 'You are an expert copywriter for a board game companion app. '
                            . 'You rewrite faction descriptions to be original and engaging while staying 100% factually accurate. '
                            . 'Return only the rewritten text, nothing else.',
                    ],
                    [
                        'role'    => 'user',
                        'content' => $prompt,
                    ],
                ],
                'temperature' => 0.6,
                'max_tokens'  => 1024,
            ]);

        if (!$response->successful()) {
            throw new RuntimeException("Groq API error {$response->status()}: {$response->body()}");
        }

        return trim($response->json('choices.0.message.content') ?? '');
    }

    /**
     * Send the prompt to the Google Gemini API.
     */
    private function callGemini(string $prompt): string
    {
        $url = sprintf(self::GEMINI_API, $this->model) . '?key=' . urlencode($this->key);

        $systemInstruction = 'You are an expert copywriter for a board game companion app. '
            . 'You rewrite faction descriptions to be original and engaging while staying 100% factually accurate. '
            . 'Return only the rewritten text, nothing else.';

        $response = Http::timeout(30)->post($url, [
            'system_instruction' => [
                'parts' => [['text' => $systemInstruction]],
            ],
            'contents' => [
                [
                    'role'  => 'user',
                    'parts' => [['text' => $prompt]],
                ],
            ],
            'generationConfig' => [
                'temperature'     => 0.6,
                'maxOutputTokens' => 1024,
            ],
        ]);

        if (!$response->successful()) {
            throw new RuntimeException("Gemini API error {$response->status()}: {$response->body()}");
        }

        return trim($response->json('candidates.0.content.parts.0.text') ?? '');
    }
}
