<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('important_dates', function (Blueprint $table) {
            $table->string('calendar')->default('lunar')->after('title'); // 'lunar' or 'solar'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('important_dates', function (Blueprint $table) {
            //
        });
    }
};
