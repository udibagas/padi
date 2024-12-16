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
        Schema::create('villages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_district_id')->constrained()->cascadeOnDelete();
            $table->string('sub_district_code', 7);
            $table->string('code', 10)->unique();
            $table->string('name', 50);
            $table->string('postal_code', 5);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villages');
    }
};
