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
        Schema::create('failed_payments', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->string('reason');
            $table->string('status')->nullable();
            $table->string('customer_email')->nullable();
            $table->foreignId('vehicle_id')->index()->references('id')->on('vehicles');
            $table->foreignId('company_id')->index()->references('id')->on('companies');
            $table->json('stripe_data')->nullable();
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failed_payments');
    }
};
