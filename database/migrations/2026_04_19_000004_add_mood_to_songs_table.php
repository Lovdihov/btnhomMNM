<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->string('mood', 20)->nullable()->after('title');
        });

        // Optional starter mapping for existing records based on genre names.
        if (Schema::hasTable('song_genres') && Schema::hasTable('genres')) {
            DB::statement("UPDATE songs s
                JOIN song_genres sg ON sg.song_id = s.id
                JOIN genres g ON g.id = sg.genre_id
                SET s.mood = 'chill'
                WHERE s.mood IS NULL AND (
                    LOWER(g.name) LIKE '%chill%' OR LOWER(g.name) LIKE '%lofi%' OR LOWER(g.name) LIKE '%indie%'
                )");

            DB::statement("UPDATE songs s
                JOIN song_genres sg ON sg.song_id = s.id
                JOIN genres g ON g.id = sg.genre_id
                SET s.mood = 'lam-viec'
                WHERE s.mood IS NULL AND (
                    LOWER(g.name) LIKE '%jazz%' OR LOWER(g.name) LIKE '%instrumental%' OR LOWER(g.name) LIKE '%piano%'
                )");

            DB::statement("UPDATE songs s
                JOIN song_genres sg ON sg.song_id = s.id
                JOIN genres g ON g.id = sg.genre_id
                SET s.mood = 'buon'
                WHERE s.mood IS NULL AND (
                    LOWER(g.name) LIKE '%ballad%' OR LOWER(g.name) LIKE '%sad%' OR LOWER(g.name) LIKE '%buon%'
                )");

            DB::statement("UPDATE songs s
                JOIN song_genres sg ON sg.song_id = s.id
                JOIN genres g ON g.id = sg.genre_id
                SET s.mood = 'party'
                WHERE s.mood IS NULL AND (
                    LOWER(g.name) LIKE '%edm%' OR LOWER(g.name) LIKE '%dance%' OR LOWER(g.name) LIKE '%rap%' OR LOWER(g.name) LIKE '%hip hop%'
                )");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->dropColumn('mood');
        });
    }
};
