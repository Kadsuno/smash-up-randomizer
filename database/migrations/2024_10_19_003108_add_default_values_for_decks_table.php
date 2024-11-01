<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('decks', function (Blueprint $table) {
            $table->string('name')->default('')->change();
            $table->string('image')->default('')->change();
            $table->text('teaser')->default('')->change();
            $table->text('description')->default('')->change();
            $table->text('cardsTeaser')->default('')->change();
            $table->text('actionTeaser')->default('')->change();
            $table->text('actionList')->default('')->change();
            $table->text('actions')->default('')->change();
            $table->text('characters')->default('')->change();
            $table->text('bases')->default('')->change();
            $table->text('clarifications')->default('')->change();
            $table->text('suggestionTeaser')->default('')->change();
            $table->text('synergy')->default('')->change();
            $table->text('tips')->default('')->change();
            $table->text('mechanics')->default('')->change();
            $table->string('expansion')->default('')->change();
            $table->string('effects')->default('')->change();
            $table->string('playstyle')->default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('decks', function (Blueprint $table) {
            $table->string('name')->default(null)->change();
            $table->string('image')->default(null)->change();
            $table->text('teaser')->default(null)->change();
            $table->text('description')->default(null)->change();
            $table->text('cardsTeaser')->default(null)->change();
            $table->text('actionTeaser')->default(null)->change();
            $table->text('actionList')->default(null)->change();
            $table->text('actions')->default(null)->change();
            $table->text('characters')->default(null)->change();
            $table->text('bases')->default(null)->change();
            $table->text('clarifications')->default(null)->change();
            $table->text('suggestionTeaser')->default(null)->change();
            $table->text('synergy')->default(null)->change();
            $table->text('tips')->default(null)->change();
            $table->text('mechanics')->default(null)->change();
            $table->string('expansion')->default(null)->change();
            $table->string('effects')->default(null)->change();
            $table->string('playstyle')->default(null)->change();
        });
    }
};
