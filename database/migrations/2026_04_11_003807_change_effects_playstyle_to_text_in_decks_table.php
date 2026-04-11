<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Change effects and playstyle from varchar(191) to text.
     *
     * The original migration defined these as string() (varchar) but they were later
     * corrected to text() in the schema file. Existing databases that ran the original
     * migration need this ALTER TABLE to match.
     */
    public function up(): void
    {
        Schema::table('decks', function (Blueprint $table) {
            $table->text('effects')->nullable()->change();
            $table->text('playstyle')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('decks', function (Blueprint $table) {
            $table->string('effects')->nullable()->change();
            $table->string('playstyle')->nullable()->change();
        });
    }
};
