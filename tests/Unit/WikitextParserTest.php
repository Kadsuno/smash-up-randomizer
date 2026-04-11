<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\WikitextParser;
use PHPUnit\Framework\TestCase;

class WikitextParserTest extends TestCase
{
    private WikitextParser $parser;
    private string $aliensWikitext;

    protected function setUp(): void
    {
        parent::setUp();
        $this->parser = new WikitextParser();
        $this->aliensWikitext = file_get_contents(__DIR__ . '/../Fixtures/aliens-wikitext.txt');
    }

    // --- parse() integration ---

    public function test_parse_returns_array_with_expected_keys(): void
    {
        $result = $this->parser->parse($this->aliensWikitext);

        $this->assertIsArray($result);

        $expectedKeys = ['description', 'cardsTeaser', 'characters', 'actionTeaser', 'actionList', 'actions', 'bases', 'clarifications', 'effects', 'tips', 'synergy', 'suggestionTeaser'];
        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $result, "Missing key: {$key}");
        }
    }

    public function test_parse_does_not_include_image_field(): void
    {
        $result = $this->parser->parse($this->aliensWikitext);

        $this->assertArrayNotHasKey('image', $result);
    }

    public function test_parse_does_not_overwrite_with_empty_values(): void
    {
        $result = $this->parser->parse('== Empty ==');

        $this->assertEmpty($result, 'parse() should return empty array when no content is extractable');
    }

    // --- extractIntro ---

    public function test_extract_intro_returns_faction_description(): void
    {
        $intro = $this->parser->extractIntro($this->aliensWikitext);

        $this->assertStringContainsString('Aliens', $intro);
        $this->assertStringContainsString('Core Set', $intro);
        $this->assertStringNotContainsString('[[File:', $intro);
        $this->assertStringNotContainsString('{{', $intro);
    }

    public function test_extract_intro_strips_quote_templates(): void
    {
        $intro = $this->parser->extractIntro($this->aliensWikitext);

        $this->assertStringNotContainsString('{{Q|', $intro);
        $this->assertStringNotContainsString('Aliens love to mess', $intro); // quote content gone
    }

    public function test_extract_intro_strips_file_embeds(): void
    {
        $intro = $this->parser->extractIntro($this->aliensWikitext);

        $this->assertStringNotContainsString('[[File:', $intro);
        $this->assertStringNotContainsString('Invader.jpg', $intro);
    }

    // --- extractCardsTeaser ---

    public function test_extract_cards_teaser_returns_cards_intro(): void
    {
        $teaser = $this->parser->extractCardsTeaser($this->aliensWikitext);

        $this->assertStringContainsString('10 minions and 10 actions', $teaser);
        // Should not include the === Minions === subsection content
        $this->assertStringNotContainsString('Supreme Overlord', $teaser);
    }

    // --- extractSection for Minions ---

    public function test_extract_section_returns_minions(): void
    {
        $characters = $this->parser->extractSection($this->aliensWikitext, 'Minions', 3);

        $this->assertStringContainsString('Supreme Overlord', $characters);
        $this->assertStringContainsString('Invader', $characters);
        $this->assertStringContainsString('Scout', $characters);
        $this->assertStringContainsString('Collector', $characters);
    }

    public function test_extract_section_minions_strips_faq_links(): void
    {
        $characters = $this->parser->extractSection($this->aliensWikitext, 'Minions', 3);
        $cleaned = $this->parser->stripMarkup($characters);

        $this->assertStringNotContainsString('[[#Questions', $cleaned);
        $this->assertStringNotContainsString('FAQ', $cleaned);
    }

    // --- extractActionTeaser ---

    public function test_extract_action_teaser_returns_action_intro_line(): void
    {
        $teaser = $this->parser->extractActionTeaser($this->aliensWikitext);

        $this->assertStringContainsString("actions focus on returning", $teaser);
    }

    // --- extractActionList ---

    public function test_extract_action_list_returns_card_entries(): void
    {
        $list = $this->parser->extractActionList($this->aliensWikitext);

        $this->assertStringContainsString('Abduction', $list);
        $this->assertStringContainsString('Beam Up', $list);
        $this->assertStringContainsString('Terraforming', $list);
    }

    public function test_extract_action_list_strips_faq_links(): void
    {
        $list = $this->parser->extractActionList($this->aliensWikitext);

        $this->assertStringNotContainsString('FAQ', $list);
        $this->assertStringNotContainsString('[[#', $list);
    }

    // --- extractSection for Bases ---

    public function test_extract_section_returns_bases(): void
    {
        $bases = $this->parser->extractSection($this->aliensWikitext, 'Bases', 3);

        $this->assertStringContainsString('The Homeworld', $bases);
        $this->assertStringContainsString('The Mothership', $bases);
    }

    // --- extractTopLevelSection for Clarifications ---

    public function test_extract_top_level_section_returns_clarifications(): void
    {
        $clarifications = $this->parser->extractTopLevelSection($this->aliensWikitext, 'Clarifications');

        $this->assertStringContainsString('return-to-hand', $clarifications);
        $this->assertStringContainsString('no longer considered', $clarifications);
    }

    // --- extractMechanicsIntro ---

    public function test_extract_mechanics_intro_returns_first_paragraph(): void
    {
        $effects = $this->parser->extractMechanicsIntro($this->aliensWikitext);

        $this->assertStringContainsString('Aliens', $effects);
        $this->assertStringContainsString('returning', $effects);
        // Should not include the ==== subsection content
        $this->assertStringNotContainsString('In isolation', $effects);
    }

    // --- Strategy / tips ---

    public function test_extract_section_returns_strategy(): void
    {
        $tips = $this->parser->extractSection($this->aliensWikitext, 'Strategy', 3);

        $this->assertStringContainsString('overall power is quite low', $tips);
        $this->assertStringContainsString('Invader Dance', $tips);
    }

    // --- Synergy ---

    public function test_extract_section_returns_synergy(): void
    {
        $synergy = $this->parser->extractSection($this->aliensWikitext, 'Synergy', 3);

        $this->assertStringContainsString('Ninjas', $synergy);
        $this->assertStringContainsString('Robots', $synergy);
    }

    // --- extractSuggestionTeaser ---

    public function test_extract_suggestion_teaser_returns_first_non_bullet_line(): void
    {
        $teaser = $this->parser->extractSuggestionTeaser($this->aliensWikitext);

        $this->assertNotEmpty($teaser);
        $this->assertStringNotContainsString('*', $teaser);
    }

    // --- stripMarkup ---

    public function test_strip_markup_removes_wiki_links(): void
    {
        $result = $this->parser->stripMarkup('[[Core Set]] rulebook');

        $this->assertSame('Core Set rulebook', $result);
    }

    public function test_strip_markup_resolves_piped_links(): void
    {
        $result = $this->parser->stripMarkup('[[Core Set|the base set]]');

        $this->assertSame('the base set', $result);
    }

    public function test_strip_markup_removes_bold(): void
    {
        $result = $this->parser->stripMarkup("'''Supreme Overlord'''");

        $this->assertSame('Supreme Overlord', $result);
    }

    public function test_strip_markup_removes_external_links_with_label(): void
    {
        $result = $this->parser->stripMarkup('[https://example.com Some Guide]');

        $this->assertSame('Some Guide', $result);
    }

    public function test_strip_markup_removes_external_links_without_label(): void
    {
        $result = $this->parser->stripMarkup('[https://example.com]');

        $this->assertSame('', trim($result));
    }

    public function test_strip_markup_removes_file_embeds(): void
    {
        $result = $this->parser->stripMarkup('[[File:Aliens.jpg|thumb|300px|right]]');

        $this->assertSame('', trim($result));
    }

    public function test_strip_markup_removes_templates(): void
    {
        $result = $this->parser->stripMarkup('{{Q|Some quote|Source}}');

        $this->assertSame('', trim($result));
    }

    public function test_strip_markup_collapses_multiple_blank_lines(): void
    {
        $result = $this->parser->stripMarkup("Line one\n\n\n\nLine two");

        $this->assertSame("Line one\n\nLine two", $result);
    }

    // --- extractSection edge cases ---

    public function test_extract_section_returns_empty_for_missing_section(): void
    {
        $result = $this->parser->extractSection($this->aliensWikitext, 'NonExistentSection', 2);

        $this->assertSame('', $result);
    }

    public function test_extract_section_does_not_bleed_into_next_section(): void
    {
        $synergy = $this->parser->extractSection($this->aliensWikitext, 'Synergy', 3);

        // External Strategy Guides comes after Synergy; should not be included
        $this->assertStringNotContainsString('smashupdata.com', strtolower($synergy));
    }
}
