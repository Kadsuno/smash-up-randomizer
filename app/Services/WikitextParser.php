<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Parses Smash Up Fandom wiki wikitext into structured Deck field values.
 *
 * Intentionally free of Laravel dependencies so it can be unit-tested
 * without booting the application container.
 *
 * Pipeline per field:
 *   raw wikitext → preprocessWikitext() → extractSection() → stripMarkup()
 *
 * preprocessWikitext() handles HTML-level noise (spans, superscripts, strikethrough).
 * stripMarkup() handles wikitext-level noise ([[links]], {{templates}}, bold/italic).
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
        // HTML-level cleanup must happen first so heading detection works correctly
        $wikitext = $this->preprocessWikitext($wikitext);

        $fields = [];

        $this->setIfNotEmpty($fields, 'description', $this->extractIntro($wikitext));
        $this->setIfNotEmpty($fields, 'cardsTeaser', $this->extractCardsTeaser($wikitext));
        $this->setIfNotEmpty($fields, 'characters', $this->stripMarkup($this->extractSection($wikitext, 'Minions', 3)));
        $this->setIfNotEmpty($fields, 'actionTeaser', $this->extractActionTeaser($wikitext));
        $this->setIfNotEmpty($fields, 'actionList', $this->extractActionList($wikitext));
        $this->setIfNotEmpty($fields, 'actions', $this->stripMarkup($this->extractSection($wikitext, 'Actions', 3)));
        $this->setIfNotEmpty($fields, 'bases', $this->stripMarkup($this->extractSection($wikitext, 'Bases', 3)));
        $this->setIfNotEmpty($fields, 'clarifications', $this->stripMarkup($this->extractTopLevelSection($wikitext, 'Clarifications')));
        $this->setIfNotEmpty($fields, 'effects', $this->extractMechanicsIntro($wikitext));
        $this->setIfNotEmpty($fields, 'tips', $this->stripMarkup($this->extractSection($wikitext, 'Strategy', 3)));
        $this->setIfNotEmpty($fields, 'synergy', $this->stripMarkup($this->extractSection($wikitext, 'Synergy', 3)));
        $this->setIfNotEmpty($fields, 'suggestionTeaser', $this->extractSuggestionTeaser($wikitext));

        return $fields;
    }

    /**
     * Pre-process wikitext before section extraction.
     *
     * Handles HTML-level noise that the MediaWiki API includes in wikitext:
     * - <s>...</s> struck-through errata'd card versions (removed entirely)
     * - <sup>...</sup> FAQ superscripts (removed entirely)
     * - <span id="..."> card-name anchors (tag removed, content kept)
     * - <span style="..."> heading decorations (tag removed, content kept)
     * - Any remaining HTML tags (stripped, content kept via strip_tags)
     *
     * After this pass, wikitext markup ([[links]], {{templates}}, '''bold''')
     * is still intact and will be handled by stripMarkup().
     */
    public function preprocessWikitext(string $wikitext): string
    {
        // Remove struck-through errata'd content entirely (old card text, superseded)
        $wikitext = preg_replace('/<s\b[^>]*>.*?<\/s>/si', '', $wikitext) ?? $wikitext;

        // Remove FAQ superscripts entirely (content is just "FAQ" / anchor links)
        $wikitext = preg_replace('/<sup\b[^>]*>.*?<\/sup>/si', '', $wikitext) ?? $wikitext;

        // Strip remaining HTML tags — keep text content, remove tags and attributes.
        // This handles <span style="...">, <span id="...">, <strong>, etc.
        // strip_tags does NOT touch {{templates}} or [[wikilinks]] since they are not HTML.
        $wikitext = strip_tags($wikitext);

        return $wikitext;
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

        // First paragraph (non-bullet, non-card-entry lines) before the card list
        $lines = explode("\n", $actionsSection);
        $teaser = [];
        foreach ($lines as $line) {
            $stripped = trim($line);
            if ($stripped === '' && !empty($teaser)) {
                break;
            }
            if ($stripped !== '' && !str_starts_with($stripped, '*') && !preg_match('/^\d+x\s/', $stripped)) {
                $teaser[] = $stripped;
            }
        }

        return $this->stripMarkup(implode(' ', $teaser));
    }

    /**
     * Extract the individual card entries from the Actions subsection as a clean line-per-card list.
     * Only current (non-errata'd) versions are included; errata notes are stripped.
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
            $stripped = trim($line);
            // Individual card entries start with Nx (e.g. "1x Abduction - ...")
            if (!preg_match('/^\d+x\s/', $stripped)) {
                continue;
            }

            // Strip errata attribution notes
            $stripped = $this->stripErrataNote($stripped);
            $cleaned = $this->stripMarkup($stripped);

            if ($cleaned !== '') {
                $listLines[] = $cleaned;
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
     * Expects preprocessed wikitext (HTML already stripped by preprocessWikitext()).
     * Headings may optionally have bold markers ('''text''') or trailing whitespace.
     *
     * @param  int  $level  2 for ==, 3 for ===, 4 for ====
     */
    public function extractSection(string $wikitext, string $header, int $level): string
    {
        $eq = str_repeat('=', $level);

        // Match the heading allowing optional bold markers and surrounding whitespace
        $pattern = '/^' . preg_quote($eq, '/') . "\s*'''?\s*" . preg_quote($header, '/') . "\s*'''?\s*" . preg_quote($eq, '/') . '\s*$/im';

        if (!preg_match($pattern, $wikitext, $matches, PREG_OFFSET_CAPTURE)) {
            // Fallback: simpler match without bold markers
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
     *
     * This method operates on already-preprocessed text (HTML removed).
     * It handles wikitext-specific markup: links, templates, bold/italic, headings.
     */
    public function stripMarkup(string $text): string
    {
        // Safety: strip any HTML tags that slipped through preprocessing
        $text = strip_tags($text);

        // Remove [[File:...]] and [[Image:...]] embeds
        $text = preg_replace('/\[\[(File|Image):[^\]]*\]\]/i', '', $text) ?? $text;

        // Remove {{template|...}} blocks (non-greedy, handles nesting via repetition)
        $text = $this->removeTemplates($text);

        // Remove internal anchor links [[#anchor|label]] and [[#anchor]]
        $text = preg_replace('/\[\[#[^\]|]+(?:\|[^\]]+)?\]\]/', '', $text) ?? $text;

        // [[Link|Display text]] → Display text
        $text = preg_replace('/\[\[[^\[\]|]+\|([^\[\]]+)\]\]/', '$1', $text) ?? $text;

        // [[Link]] → Link text (strip the brackets)
        $text = preg_replace('/\[\[([^\[\]]+)\]\]/', '$1', $text) ?? $text;

        // [https://... label] → label
        $text = preg_replace('/\[https?:\/\/\S+\s+([^\]]+)\]/', '$1', $text) ?? $text;

        // [https://...] (no label) → remove
        $text = preg_replace('/\[https?:\/\/\S+\]/', '', $text) ?? $text;

        // '''bold''' → text
        $text = preg_replace("/'''(.+?)'''/s", '$1', $text) ?? $text;

        // ''italic'' markers → remove (unpaired single-quotes after bold stripping)
        $text = preg_replace("/''/", '', $text) ?? $text;

        // ==headings== at any level → remove the whole line
        $text = preg_replace('/^={2,6}[^=\n]+={2,6}\s*$/m', '', $text) ?? $text;

        // Errata attribution notes — strip from card text fields
        $text = $this->stripErrataNote($text);

        // HTML entities
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Trim each line and collapse multiple blank lines into one
        $lines = array_map('trim', explode("\n", $text));
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
     * Strip "(errata'd by ...)" attribution notes from a line of card text.
     */
    private function stripErrataNote(string $text): string
    {
        return preg_replace("/\s*\(errata'd by[^)]*\)/i", '', $text) ?? $text;
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
