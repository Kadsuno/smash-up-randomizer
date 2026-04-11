<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add id (primary key) and timestamps to the decks table.
     *
     * These columns are missing from the original create_decks_table migration.
     * Guards are in place so this is safe to run on existing databases that
     * already have these columns added manually.
     */
    public function up(): void
    {
        Schema::table('decks', function (Blueprint $table) {
            if (!Schema::hasColumn('decks', 'id')) {
                $table->id()->first();
            }

            if (!Schema::hasColumn('decks', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('decks', function (Blueprint $table) {
            if (Schema::hasColumn('decks', 'created_at')) {
                $table->dropTimestamps();
            }

            if (Schema::hasColumn('decks', 'id')) {
                $table->dropColumn('id');
            }
        });
    }
};
