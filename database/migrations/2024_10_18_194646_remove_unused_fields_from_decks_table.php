<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $columns = [
            'strengths',
            'weaknesses',
            'strategy',
            'counterStrategy',
            'antiSynergy',
            'deckType',
        ];

        $toDrop = array_values(array_filter($columns, fn (string $col) => Schema::hasColumn('decks', $col)));

        if ($toDrop === []) {
            return;
        }

        Schema::table('decks', function (Blueprint $table) use ($toDrop) {
            $table->dropColumn($toDrop);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('decks', function (Blueprint $table) {
            $table->text('strengths');
            $table->text('weaknesses');
            $table->text('strategy');
            $table->text('counterStrategy');
            $table->text('antiSynergy');
            $table->text('deckType');
        });
    }
};
