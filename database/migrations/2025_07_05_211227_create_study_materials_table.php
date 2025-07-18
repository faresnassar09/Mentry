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
        Schema::create('study_materials', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

            $table->string('title',40)->nullable();
            $table->string('path',100); 
            $table->boolean('type')->default(1)->comment(" 1 => Mini Book, 2 => summer ");
            $table->timestamp('last_read')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_materials');
    }
};
