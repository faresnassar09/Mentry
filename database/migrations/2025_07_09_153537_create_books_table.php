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
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
            ->constrained()
            ->cascadeOnDelete(); 

            $table->string('title',40);
            $table->string('author',40);
            $table->string('cover_path')->nullable();
            $table->string('book_path');
            $table->text('description')->nullable();
            $table->integer('pages')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
