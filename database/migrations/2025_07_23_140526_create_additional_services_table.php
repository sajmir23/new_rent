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
        Schema::create('additional_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->index()->references('id')->on('companies');
            $table->string('title_en');
            $table->string('title_it');
            $table->string('title_al');
            $table->string('title_es');
            $table->string('title_de');
            $table->string('title_fr');
            $table->text('description_en');
            $table->text('description_it');
            $table->text('description_al');
            $table->text('description_es');
            $table->text('description_de');
            $table->text('description_fr');
            $table->decimal('service_price');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_services');
    }
};
