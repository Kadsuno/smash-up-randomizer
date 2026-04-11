<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\WikitextParser;
use PHPUnit\Framework\TestCase;

class WikitextParserTest extends TestCase
{
    private WikitextParser $parser;

    /** Raw wikitext as returned by the MediaWiki API (contains HTML spans, <s>, <sup>, etc.) */
    private string $rawWikitext;

    /** Preprocessed wikitext — HTML stripped, ready for section extraction and stripMarkup(). */
    private string $aliensWikitext;

    protected function setUp(): void
    {
        parent::setUp();
        $this->parser = new WikitextParser();
        $this->rawWikitext = file_get_contents(__DIR__ . '/../Fixtures/aliens-wikitext.txt');
        // Individual extraction method tests operate on preprocessed wikitext,
        // matching exactly what parse() does internally.
        $this->aliensWikitext = $this->parser->preprocessWikitext($this->rawWikitext);
    }

    // --- preprocessWikitext ---

    public function test_preprocess_removes_strikethrough_content(): void
    {
        $result = $this->parser->preprocessWikitext(
            "<s>3x '''Scout''' - old errata'd text</s>\n3x Scout - current text"
        );

        $this->assertStringNotContainsString("<s>", $result);
        $this->assertStringNotContainsString("old errata'd text", $result);
        $this->assertStringContainsString('Scout - current text', $result);
    }

    public function test_preprocess_removes_faq_superscripts(): void
    {
        $result = $this->parser->preprocessWikitext(
            "1x Abduction - Return a minion. <sup>[[#Questions on Abduction|FAQ]]</sup>"
        );

        $this->assertStringNotContainsString('<sup>', $result);
        $this->assertStringNotContainsString('FAQ', $result);
        $this->assertStringContainsString('1x Abduction - Return a minion.', $result);
    }

    public function test_preprocess_strips_html_span_tags_keeping_content(): void
    {
        $result = $this->parser->preprocessWikitext(
            "1x <span id=\"Supreme_Overlord\">'''Supreme Overlord'''</span> - power 5"
        );

        $this->assertStringNotContainsString('<span', $result);
        $this->assertStringNotContainsString('id="Supreme_Overlord"', $result);
        $this->assertStringContainsString("'''Supreme Overlord'''", $result);
        $this->assertStringContainsString('power 5', $result);
    }

    public function test_preprocess_normalizes_html_decorated_headings(): void
    {
        $heading = "== <span style=\"{{ColorOutline | #FFFFFF}}; color:#8F3371\">'''Cards'''</span> ==";
        $result = $this->parser->preprocessWikitext($heading);

        $this->assertStringNotContainsString('<span', $result);
        $this->assertStringNotContainsString('ColorOutline', $result);
        $this->assertStringContainsString("'''Cards'''", $result);
    }

    public function test_preprocess_on_live_fixture_removes_all_html(): void
    {
        $this->assertStringNotContainsString('<span', $this->aliensWikitext);
        $this->assertStringNotContainsString('<sup>', $this->aliensWikitext);
        $this->assertStringNotContainsString('<s>', $this->aliensWikitext);
    }

    public function test_preprocess_excludes_erratad_old_card_versions(): void
    {
        // Old Scout text (struck through) should be removed
        $this->assertStringNotContainsString('place this minion into your hand', $this->aliensWikitext);
        // Current Scout text should remain
        $this->assertStringContainsString('return this minion to your hand', $this->aliensWikitext);
    }

    // --- parse() integration ---

    public function test_parse_returns_array_with_expected_keys(): void
    {
        $result = $this->parser->parse($this->rawWikitext);

        $this->assertIsArray($result);

        $expectedKeys = ['description', 'cardsTeaser', 'characters', 'actionList', 'actions', 'bases', 'clarifications', 'effects', 'tips', 'synergy', 'suggestionTeaser'];
        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $result, "Missing key: {$key}");
        }
    }

    public function test_parse_does_not_include_image_field(): void
    {
        $result = $this->parser->parse($this->rawWikitext);

        $this->assertArrayNotHasKey('image', $result);
    }

    public function test_parse_does_not_overwrite_with_empty_values(): void
    {
        $result = $this->parser->parse('== Empty ==');

        $this->assertEmpty($result, 'parse() should return empty array when no content is extractable');
    }

    public function test_parse_output_contains_no_html_tags(): void
    {
        $result = $this->parser->parse($this->rawWikitext);

        foreach ($result as $key => $value) {
            $this->assertStringNotContainsString('<span', $value, "Field '{$key}' contains <span> tags");
            $this->assertStringNotContainsString('<sup>', $value, "Field '{$key}' contains <sup> tags");
            $this->assertStringNotContainsString('<s>', $value, "Field '{$key}' contains <s> tags");
        }
    }

    public function test_parse_output_contains_no_wiki_links(): void
    {
        $result = $this->parser->parse($this->rawWikitext);

        foreach ($result as $key => $value) {
            $this->assertStringNotContainsString('[[', $value, "Field '{$key}' contains [[wiki links]]");
            $this->assertStringNotContainsString('{{', $value, "Field '{$key}' contains {{templates}}");
        }
    }

    public function test_parse_output_contains_no_faq_references(): void
    {
        $result = $this->parser->parse($this->rawWikitext);

        foreach ($result as $key => $value) {
            $this->assertStringNotContainsString('FAQ', $value, "Field '{$key}' contains FAQ references");
        }
    }

    // --- extractIntro ---

    public function test_extract_intro_returns_faction_description(): void
    {
        $intro = $this->parser->extractIntro($this->aliensWikitext);

        $this->assertStringContainsString('Aliens', $intro);
        $this->assertStringContainsString('Core Set', $intro);
    }

    public function test_extract_intro_strips_quote_templates(): void
    {
        $intro = $this->parser->extractIntro($this->aliensWikitext);

        $this->assertStringNotContainsString('{{Q|', $intro);
        $this->assertStringNotContainsString('Aliens love to mess', $intro);
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

    // --- extractSection for Minions / characters ---

    public function test_extract_section_returns_minions(): void
    {
        $characters = $this->parser->extractSection($this->aliensWikitext, 'Minions', 3);

        $this->assertStringContainsString('Supreme Overlord', $characters);
        $this->assertStringContainsString('Invader', $characters);
        $this->assertStringContainsString('Scout', $characters);
        $this->assertStringContainsString('Collector', $characters);
    }

    public function test_extract_section_minions_excludes_erratad_old_versions(): void
    {
        // Preprocessing already removed <s> blocks; old Scout text should be gone
        $characters = $this->parser->extractSection($this->aliensWikitext, 'Minions', 3);

        $this->assertStringNotContainsString('place this minion into your hand', $characters);
        $this->assertStringContainsString('return this minion to your hand', $characters);
    }

    public function test_extract_section_minions_strips_faq_links(): void
    {
        $characters = $this->parser->extractSection($this->aliensWikitext, 'Minions', 3);
        $cleaned = $this->parser->stripMarkup($characters);

        $this->assertStringNotContainsString('[[#Questions', $cleaned);
        $this->assertStringNotContainsString('FAQ', $cleaned);
    }

    public function test_extract_section_minions_strips_errata_notes(): void
    {
        $characters = $this->parser->extractSection($this->aliensWikitext, 'Minions', 3);
        $cleaned = $this->parser->stripMarkup($characters);

        $this->assertStringNotContainsString("errata'd", $cleaned);
    }

    // --- extractActionList ---

    public function test_extract_action_list_returns_card_entries(): void
    {
        $list = $this->parser->extractActionList($this->aliensWikitext);

        $this->assertStringContainsString('Abduction', $list);
        $this->assertStringContainsString('Beam Up', $list);
        $this->assertStringContainsString('Terraforming', $list);
    }

    public function test_extract_action_list_excludes_erratad_old_versions(): void
    {
        $list = $this->parser->extractActionList($this->aliensWikitext);

        // Old Jammed Signal text (stripped via <s>) should not appear
        $this->assertStringNotContainsString('All players ignore this base', $list);
        // Current version should be present
        $this->assertStringContainsString('Jammed Signal', $list);
    }

    public function test_extract_action_list_strips_faq_links(): void
    {
        $list = $this->parser->extractActionList($this->aliensWikitext);

        $this->assertStringNotContainsString('FAQ', $list);
        $this->assertStringNotContainsString('[[#', $list);
    }

    public function test_extract_action_list_strips_errata_notes(): void
    {
        $list = $this->parser->extractActionList($this->aliensWikitext);

        $this->assertStringNotContainsString("errata'd", $list);
    }

    // --- extractSection for Bases ---

    public function test_extract_section_returns_bases(): void
    {
        $bases = $this->parser->extractSection($this->aliensWikitext, 'Bases', 3);
        $cleaned = $this->parser->stripMarkup($bases);

        $this->assertStringContainsString('The Homeworld', $cleaned);
        $this->assertStringContainsString('The Mothership', $cleaned);
        $this->assertStringNotContainsString('[[', $cleaned);
    }

    // --- extractTopLevelSection for Clarifications ---

    public function test_extract_top_level_section_returns_clarifications(): void
    {
        $clarifications = $this->parser->stripMarkup(
            $this->parser->extractTopLevelSection($this->aliensWikitext, 'Clarifications')
        );

        $this->assertStringContainsString('Collector', $clarifications);
        $this->assertStringContainsString('Invader', $clarifications);
        $this->assertStringContainsString('Jammed Signal', $clarifications);
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

    public function test_extract_strategy_strips_wiki_links(): void
    {
        $tips = $this->parser->stripMarkup(
            $this->parser->extractSection($this->aliensWikitext, 'Strategy', 3)
        );

        $this->assertStringNotContainsString('[[', $tips);
        $this->assertStringContainsString('breaking bases', $tips);
    }

    // --- Synergy ---

    public function test_extract_section_returns_synergy(): void
    {
        $synergy = $this->parser->extractSection($this->aliensWikitext, 'Synergy', 3);

        $this->assertStringContainsString('Ninjas', $synergy);
        $this->assertStringContainsString('Robots', $synergy);
    }

    public function test_extract_synergy_strips_wiki_links(): void
    {
        $synergy = $this->parser->stripMarkup(
            $this->parser->extractSection($this->aliensWikitext, 'Synergy', 3)
        );

        $this->assertStringNotContainsString('[[', $synergy);
        $this->assertStringContainsString('Ninjas', $synergy);
    }

    // --- extractSuggestionTeaser ---

    public function test_extract_suggestion_teaser_returns_first_non_bullet_line(): void
    {
        $teaser = $this->parser->extractSuggestionTeaser($this->aliensWikitext);

        $this->assertNotEmpty($teaser);
        $this->assertStringNotContainsString('*', $teaser);
        $this->assertStringContainsString('returning minions', $teaser);
    }

    // --- extractSection does not bleed ---

    public function test_extract_section_returns_empty_for_missing_section(): void
    {
        $result = $this->parser->extractSection($this->aliensWikitext, 'NonExistentSection', 2);

        $this->assertSame('', $result);
    }

    public function test_extract_section_does_not_bleed_into_next_section(): void
    {
        $synergy = $this->parser->extractSection($this->aliensWikitext, 'Synergy', 3);

        // External Strategy Guides comes after Synergy; must not bleed in
        $this->assertStringNotContainsString('smashupdata.com', strtolower($synergy));
    }

    // --- stripMarkup unit tests ---

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

    public function test_strip_markup_strips_errata_notes(): void
    {
        $result = $this->parser->stripMarkup("1x Jammed Signal - Play on a base. (errata'd by Smash Up POD)");

        $this->assertSame('1x Jammed Signal - Play on a base.', $result);
    }

    public function test_strip_markup_strips_remaining_html_tags(): void
    {
        $result = $this->parser->stripMarkup('<strong>Bold text</strong> normal text');

        $this->assertStringNotContainsString('<strong>', $result);
        $this->assertStringContainsString('Bold text', $result);
    }
}
