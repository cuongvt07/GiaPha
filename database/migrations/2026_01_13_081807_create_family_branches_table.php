<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('root_ancestor_id')->nullable()->constrained('people')->nullOnDelete();
            $table->foreignId('parent_branch_id')->nullable()->constrained('family_branches')->nullOnDelete();
            $table->string('branch_name');
            $table->string('branch_location')->nullable();
            $table->text('description')->nullable();
            $table->integer('branch_order')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_branches');
    }
};
