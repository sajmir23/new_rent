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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_code')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthday');
            $table->string('email');
            $table->string('phone');
            $table->string('additional_phone')->nullable();
            $table->integer('days');
            $table->decimal('daily_rate');
            $table->decimal('total_price');
            $table->decimal('addons_total');
            $table->decimal('deliveries_total', 10, 2)->default(0);
            $table->date('pickup_date');
            $table->date('dropoff_date');
            $table->time('pickup_time');
            $table->time('dropoff_time');
            $table->tinyInteger('ways_of_contact')->nullable(); //  1->whatsapp, 2->telegram 3->viber
            $table->foreignId('created_by')->nullable()->references('id')->on('users');
            $table->foreignId('insurance_id')->index()->references('id')->on('insurances');
            $table->foreignId('vehicle_id')->index()->references('id')->on('vehicles');
            $table->foreignId('company_id')->index()->references('id')->on('companies');
            $table->foreignId('pickup_location')->index()->references('id')->on('deliveries');
            $table->foreignId('dropoff_location')->index()->references('id')->on('deliveries');
            $table->foreignId('booking_status_id')->index()->references('id')->on('booking_statuses');
            $table->datetime('cancelled_at')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('commission_amount');
            $table->string('session_id')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
