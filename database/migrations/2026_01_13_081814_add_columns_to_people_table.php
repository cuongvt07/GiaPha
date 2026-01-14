<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->foreignId('family_branch_id')->nullable()->constrained('family_branches')->nullOnDelete();
            $table->foreignId('generation_id')->nullable()->constrained('generations')->nullOnDelete();
            $table->foreignId('root_ancestor_id')->nullable()->constrained('people')->nullOnDelete();
            
            $table->string('place_of_birth')->nullable();
            $table->string('hometown')->nullable();
            $table->string('occupation')->nullable();
            $table->string('title')->nullable(); // Chức vụ / Học vị chính
            $table->integer('birth_order')->nullable();
            $table->string('lineage_position')->nullable(); // Trưởng nam, thứ nam...
        });
    }

    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropForeign(['family_branch_id']);
            $table->dropForeign(['generation_id']);
            $table->dropForeign(['root_ancestor_id']);
            
            $table->dropColumn([
                'family_branch_id',
                'generation_id',
                'root_ancestor_id',
                'place_of_birth',
                'hometown',
                'occupation',
                'title',
                'birth_order',
                'lineage_position'
            ]);
        });
    }
};
