<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('decks', function (Blueprint $table) {
            $table->string('teaser');
            $table->text('description');
            $table->text('cardsTeaser');
            $table->text('actions');
            $table->text('characters');
            $table->text('bases');
            $table->text('suggestionTeaser');
            $table->text('synergy');
            $table->text('tips');
            $table->text('mechanics');
            $table->text('expansion');
            $table->text('effects');
            $table->text('playstyle');
            $table->text('actionTeaser');
            $table->text('actionList');
            $table->text('clarifications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('decks');
    }
}
