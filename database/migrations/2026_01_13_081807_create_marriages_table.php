<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marriages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('husband_id')->constrained('people')->cascadeOnDelete();
            $table->foreignId('wife_id')->constrained('people')->cascadeOnDelete();
            $table->enum('marriage_type', ['chinh_thuc', 'vo_le', 'thiep'])->default('chinh_thuc');
            $table->integer('marriage_order')->default(1);
            $table->date('marriage_date')->nullable();
            $table->date('divorce_date')->nullable();
            $table->enum('status', ['active', 'divorced', 'widowed'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marriages');
    }
};
