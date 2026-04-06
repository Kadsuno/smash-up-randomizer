<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * create_decks_table did not include name/image; a later migration assumed they exist.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('decks', 'name')) {
            Schema::table('decks', function (Blueprint $table) {
                $table->string('name')->default('');
            });
        }

        if (! Schema::hasColumn('decks', 'image')) {
            Schema::table('decks', function (Blueprint $table) {
                $table->string('image')->default('');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('decks', function (Blueprint $table) {
            if (Schema::hasColumn('decks', 'image')) {
                $table->dropColumn('image');
            }
        });

        Schema::table('decks', function (Blueprint $table) {
            if (Schema::hasColumn('decks', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
};
