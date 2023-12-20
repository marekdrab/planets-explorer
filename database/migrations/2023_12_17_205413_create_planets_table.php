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
        Schema::create('planets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rotation_period')->nullable();
            $table->string('orbital_period')->nullable();
            $table->string('diameter')->nullable();
            $table->string('climate')->nullable();
            $table->string('gravity')->nullable();
            $table->string('terrain')->nullable();
            $table->string('surface_water')->nullable();
            $table->string('population')->nullable();
            // Add other fields you need
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planets');
    }
};
