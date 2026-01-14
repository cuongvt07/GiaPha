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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('father_id')->nullable()->constrained('people')->nullOnDelete();
            $table->foreignId('mother_id')->nullable()->constrained('people')->nullOnDelete();
            $table->foreignId('spouse_id')->nullable()->constrained('people')->nullOnDelete();
            $table->string('name');
            $table->string('nickname')->nullable();
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_death')->nullable();
            $table->boolean('is_alive')->default(true);
            $table->text('biography')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('avatar_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
