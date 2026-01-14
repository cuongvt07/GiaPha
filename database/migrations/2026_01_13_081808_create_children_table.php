<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('people')->cascadeOnDelete();
            $table->foreignId('marriage_id')->constrained('marriages')->cascadeOnDelete();
            $table->integer('birth_order_overall')->nullable();
            $table->integer('birth_order_by_mother')->nullable();
            $table->enum('child_type', ['biological', 'adopted', 'step'])->default('biological');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};
