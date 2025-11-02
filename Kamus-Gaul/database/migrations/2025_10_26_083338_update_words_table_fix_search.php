<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop existing fulltext index if it exists
        if (Schema::hasIndex('words', 'words_kata_definisi_tags_fulltext')) {
            DB::statement('ALTER TABLE words DROP INDEX words_kata_definisi_tags_fulltext');
        }

        // Add fulltext index again
        DB::statement('ALTER TABLE words ADD FULLTEXT(kata, definisi, tags)');
    }

    public function down(): void
    {
        // Drop fulltext index
        DB::statement('ALTER TABLE words DROP INDEX kata');
    }
};
