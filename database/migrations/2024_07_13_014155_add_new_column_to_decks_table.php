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
        // Columns were added in create_decks_table before this migration shipped; keep idempotent for fresh installs.
        if (Schema::hasColumn('decks', 'actionTeaser')) {
            return;
        }

        Schema::table('decks', function (Blueprint $table) {
            $table->text('actionTeaser');
            $table->text('actionList');
            $table->text('clarifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('decks', function (Blueprint $table) {
            //
        });
    }
};
