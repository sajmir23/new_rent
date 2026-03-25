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
        Schema::create('vehicle_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->index()->references('id')->on('vehicles');
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->string('name');
            $table->string('path')->nullable();
            $table->string('mime')->nullable();
            $table->string('size')->nullable(); //in kb
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_images');
    }
};
