<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string('kata');
            $table->text('definisi');
            $table->text('contoh');
            $table->string('tags');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Add indexes
            $table->index('kata');
            $table->index('definisi');
            $table->index('tags');

            // Add fulltext index for search
            $table->fullText(['kata', 'definisi', 'tags']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('words');
    }
};
