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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->index()->references('id')->on('companies');
            $table->foreignId('vehicle_model_id')->index()->references('id')->on('vehicle_models');
            $table->foreignId('vehicle_category_id')->index()->references('id')->on('vehicle_categories');
            $table->foreignId('fuel_type_id')->index()->references('id')->on('fuel_types');
            $table->foreignId('transmission_type_id')->index()->references('id')->on('transmission_types');
            $table->foreignId('vehicle_status_id')->index()->references('id')->on('vehicle_statuses');
            $table->foreignId('created_by')->index()->references('id')->on('users');
            $table->foreignId('updated_by')->index()->nullable()->references('id')->on('users');
            $table->string('title');
            $table->string('slug')->unique();
            $table->decimal('engine_size')->nullable();
            $table->decimal('base_daily_rate', 8, 2)->nullable();
            $table->string('plate')->unique();
            $table->string('vin')->unique()->nullable();
            $table->date('registration_expiry')->nullable();
            $table->date('insurance_expiry')->nullable();
            $table->string('year')->nullable();
            $table->string('mileage')->nullable();
            $table->string('color')->nullable();
            $table->integer('seats')->nullable();
            $table->string('notes')->nullable();

            //requirements
            $table->integer('min_drive_age')->nullable();
            $table->integer('max_drive_age')->nullable();
            $table->boolean('international_licence_required')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
