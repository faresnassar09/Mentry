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
        Schema::create('study_schedual_items', function (Blueprint $table) {
            $table->id();  

            $table->foreignId('study_schedual_id')
            ->constrained()
            ->cascadeOnDelete(); 

            $table->timestamp('ends_at');
            $table->string('task',100);
            $table->boolean('status')->default(1)->comment('0 => end, 1=> active , 2 => compleated');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_schedual_items');
    }
};
