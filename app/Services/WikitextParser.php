<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Parses Smash Up Fandom wiki wikitext into structured Deck field values.
 *
 * Intentionally free of Laravel dependencies so it can be unit-tested
 * without booting the application container.
 */
class WikitextParser
{
    /**
     * Parse a full wikitext page into an array of Deck fillable fields.
     *
     * Only fields with non-empty extracted content are included in the result,
     * so callers can safely merge without overwriting existing data.
     *
     * @param  string  $wikitext  Raw wikitext from the MediaWiki API
     * @return array<string, string>
     */
    public function parse(string $wikitext): array
    {
        $fields = [];

        $this->setIfNotEmpty($fields, 'description', $this->extractIntro($wikitext));
        $this->setIfNotEmpty($fields, 'cardsTeaser', $this->extractCardsTeaser($wikitext));
        $this->setIfNotEmpty($fields, 'characters', $this->extractSection($wikitext, 'Minions', 3));
        $this->setIfNotEmpty($fields, 'actionTeaser', $this->extractActionTeaser($wikitext));
        $this->setIfNotEmpty($fields, 'actionList', $this->extractActionList($wikitext));
        $this->setIfNotEmpty($fields, 'actions', $this->extractSection($wikitext, 'Actions', 3));
        $this->setIfNotEmpty($fields, 'bases', $this->extractSection($wikitext, 'Bases', 3));
        $this->setIfNotEmpty($fields, 'clarifications', $this->extractTopLevelSection($wikitext, 'Clarifications'));
        $this->setIfNotEmpty($fields, 'effects', $this->extractMechanicsIntro($wikitext));
        $this->setIfNotEmpty($fields, 'tips', $this->extractSection($wikitext, 'Strategy', 3));
        $this->setIfNotEmpty($fields, 'synergy', $this->extractSection($wikitext, 'Synergy', 3));
        $this->setIfNotEmpty($fields, 'suggestionTeaser', $this->extractSuggestionTeaser($wikitext));

        return $fields;
    }

    /**
     * Extract the intro paragraph (section 0) — the text before the first == heading ==.
     * Strips the quote block, file embeds, and other templates.
     */
    public function extractIntro(string $wikitext): string
    {
        // Everything before the first level-2 heading
        $parts = preg_split('/^==\s/m', $wikitext, 2);
        $intro = $parts[0] ?? '';

        // Remove {{Quote|...}} and similar templates
        $intro = $this->removeTemplates($intro);
        // Remove [[File:...]] embeds
        $intro = preg_replace('/\[\[File:[^\]]*\]\]/i', '', $intro) ?? $intro;

        return $this->stripMarkup(trim($intro));
    }

    /**
     * Extract the intro paragraph of the == Cards == section (before first === subsection ===).
     */
    public function extractCardsTeaser(string $wikitext): string
    {
        $section = $this->extractTopLevelSection($wikitext, 'Cards');
        if ($section === '') {
            return '';
        }

        // Take only content before the first === subsection ===
        $parts = preg_split('/^===\s/m', $section, 2);

        return $this->stripMarkup(trim($parts[0] ?? ''));
    }

    /**
     * Extract the "Among their actions, there are:" intro line from the Actions subsection.
     */
    public function extractActionTeaser(string $wikitext): string
    {
        $actionsSection = $this->extractSection($wikitext, 'Actions', 3);
        if ($actionsSection === '') {
            return '';
        }

        // First paragraph before the bullet list
        $lines = explode("\n", $actionsSection);
        $teaser = [];
        foreach ($lines as $line) {
            $stripped = trim($line);
            if ($stripped === '' && !empty($teaser)) {
                break;
            }
            if ($stripped !== '' && !str_starts_with($stripped, '*')) {
                $teaser[] = $stripped;
            }
        }

        return $this->stripMarkup(implode(' ', $teaser));
    }

    /**
     * Extract the bullet-list of action cards from the Actions subsection.
     */
    public function extractActionList(string $wikitext): string
    {
        $actionsSection = $this->extractSection($wikitext, 'Actions', 3);
        if ($actionsSection === '') {
            return '';
        }

        $lines = explode("\n", $actionsSection);
        $listLines = [];

        foreach ($lines as $line) {
            $stripped = ltrim($line);
            // Individual card entries start with Nx (e.g. "1x '''Abduction'''")
            if (preg_match('/^\d+x\s/', $stripped)) {
                // Strip the errata notes in italics at line end
                $stripped = preg_replace('/\s*\(errata\'d[^)]*\)/', '', $stripped) ?? $stripped;
                // Remove duplicate errata lines (lines with "errata'd" mid-text)
                if (str_contains($stripped, "errata'd")) {
                    continue;
                }
                $listLines[] = $this->stripMarkup(trim($stripped));
            }
        }

        return implode("\n", $listLines);
    }

    /**
     * Extract the intro text of the == Mechanics == section (before subsections).
     */
    public function extractMechanicsIntro(string $wikitext): string
    {
        $section = $this->extractTopLevelSection($wikitext, 'Mechanics');
        if ($section === '') {
            return '';
        }

        // Strip subsections (level 3+): split on any line starting with 3+ = signs
        $parts = preg_split('/^={3,}[^=]/m', $section, 2);

        return $this->stripMarkup(trim($parts[0] ?? ''));
    }

    /**
     * Extract the first sentence of the Synergy section as the suggestionTeaser.
     */
    public function extractSuggestionTeaser(string $wikitext): string
    {
        $synergy = $this->extractSection($wikitext, 'Synergy', 3);
        if ($synergy === '') {
            return '';
        }

        // First non-bullet, non-empty line
        $lines = explode("\n", $synergy);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line !== '' && !str_starts_with($line, '*')) {
                // Take up to the first sentence end
                $pos = strpos($line, '. ');
                $teaser = $pos !== false ? substr($line, 0, $pos + 1) : $line;

                return $this->stripMarkup($teaser);
            }
        }

        return '';
    }

    /**
     * Extract the full content of a top-level (==) wiki section by name.
     * Returns content between this heading and the next == heading (exclusive).
     */
    public function extractTopLevelSection(string $wikitext, string $header): string
    {
        return $this->extractSection($wikitext, $header, 2);
    }

    /**
     * Extract the content of a wiki section at a given heading level.
     *
     * @param  int  $level  2 for ==, 3 for ===, 4 for ====
     */
    public function extractSection(string $wikitext, string $header, int $level): string
    {
        $eq = str_repeat('=', $level);
        // Match the heading, case-insensitively, allowing surrounding spaces and bold markup
        $pattern = '/^' . preg_quote($eq, '/') . "\s*'''?\s*" . preg_quote($header, '/') . "\s*'''?\s*" . preg_quote($eq, '/') . '\s*$/im';

        if (!preg_match($pattern, $wikitext, $matches, PREG_OFFSET_CAPTURE)) {
            // Try simpler match without bold
            $pattern = '/^' . preg_quote($eq, '/') . '\s*' . preg_quote($header, '/') . '\s*' . preg_quote($eq, '/') . '\s*$/im';
            if (!preg_match($pattern, $wikitext, $matches, PREG_OFFSET_CAPTURE)) {
                return '';
            }
        }

        $start = $matches[0][1] + strlen($matches[0][0]);

        // Find the next heading of same or higher level (fewer or equal = signs)
        $nextPattern = '/^={1,' . $level . '}[^=]/m';
        $remaining = substr($wikitext, $start);

        if (preg_match($nextPattern, $remaining, $nextMatch, PREG_OFFSET_CAPTURE)) {
            $end = $nextMatch[0][1];
            $content = substr($remaining, 0, $end);
        } else {
            $content = $remaining;
        }

        return trim($content);
    }

    /**
     * Strip all wiki markup from a text string, returning plain text.
     */
    public function stripMarkup(string $text): string
    {
        // Remove [[File:...]] and [[Image:...]] embeds (may span multiple chars)
        $text = preg_replace('/\[\[(File|Image):[^\]]*\]\]/i', '', $text) ?? $text;

        // Remove {{template|...}} blocks (non-greedy, handles nesting via repetition)
        $text = $this->removeTemplates($text);

        // Remove internal anchor links [[#anchor|label]] and [[#anchor]] — must come before generic piped link
        $text = preg_replace('/\[\[#[^\]|]+(?:\|[^\]]+)?\]\]/', '', $text) ?? $text;

        // [[Link|Display text]] → Display text
        $text = preg_replace('/\[\[[^\[\]|]+\|([^\[\]]+)\]\]/', '$1', $text) ?? $text;

        // [[Link]] → Link
        $text = preg_replace('/\[\[([^\[\]]+)\]\]/', '$1', $text) ?? $text;

        // [https://... label] → label
        $text = preg_replace('/\[https?:\/\/\S+\s+([^\]]+)\]/', '$1', $text) ?? $text;

        // [https://...] (no label) → remove
        $text = preg_replace('/\[https?:\/\/\S+\]/', '', $text) ?? $text;

        // '''bold''' → text
        $text = preg_replace("/'''(.+?)'''/s", '$1', $text) ?? $text;

        // ''italic'' → text
        $text = preg_replace("/''/", '', $text) ?? $text;

        // ==headings== at any level → remove the whole line
        $text = preg_replace('/^={2,6}[^=\n]+={2,6}\s*$/m', '', $text) ?? $text;

        // FAQ links like [[#Questions on X|FAQ]] → remove
        $text = preg_replace('/\[\[#[^\]]+\|[^\]]+\]\]/', '', $text) ?? $text;

        // HTML entities
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Trim each line
        $lines = array_map('trim', explode("\n", $text));

        // Collapse multiple blank lines into one
        $result = [];
        $prevBlank = false;
        foreach ($lines as $line) {
            $isBlank = ($line === '');
            if ($isBlank && $prevBlank) {
                continue;
            }
            $result[] = $line;
            $prevBlank = $isBlank;
        }

        return trim(implode("\n", $result));
    }

    /**
     * Remove {{template|...}} blocks from text.
     * Handles single-level nesting; iterates for deeper nesting.
     */
    private function removeTemplates(string $text): string
    {
        // Iterate up to 5 times to handle nested templates
        for ($i = 0; $i < 5; $i++) {
            $new = preg_replace('/\{\{[^{}]*\}\}/', '', $text) ?? $text;
            if ($new === $text) {
                break;
            }
            $text = $new;
        }

        return $text;
    }

    /**
     * Only add a field if the extracted value is non-empty.
     *
     * @param  array<string, string>  $fields
     */
    private function setIfNotEmpty(array &$fields, string $key, string $value): void
    {
        if (trim($value) !== '') {
            $fields[$key] = $value;
        }
    }
}
