<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('people')->cascadeOnDelete();
            $table->string('title')->nullable(); // Tiến sĩ, Giáo sư...
            $table->string('achievement_type')->nullable(); // Học vị, Công trạng...
            $table->date('achievement_date')->nullable();
            $table->text('description')->nullable();
            $table->integer('display_order')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
