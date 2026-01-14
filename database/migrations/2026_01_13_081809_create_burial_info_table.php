<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('burial_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('people')->cascadeOnDelete();
            $table->string('burial_place')->nullable();
            $table->date('burial_date')->nullable();
            $table->string('gps_coordinates')->nullable();
            $table->string('grave_type')->nullable(); // Mộ đơn, đôi, gia tộc...
            $table->text('grave_description')->nullable();
            $table->string('grave_photo_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('burial_info');
    }
};
