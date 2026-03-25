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
        Schema::create('feature_vehicle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->index()->references('id')->on('vehicles');
            $table->foreignId('feature_id')->index()->references('id')->on('features');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_vehicle');
    }
};
