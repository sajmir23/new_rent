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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('text_color')->nullable();
            $table->string('background_color')->nullable();
            $table->longText('description')->nullable();
            $table->string('notes')->nullable();
            $table->integer('status')->default(1); // 1-> active , 0->inactive
            $table->string('scope')->default('company'); // 'system' or 'company'
            $table->foreignId('company_id')->index()->nullable()->references('id')->on('companies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
