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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade'); //who did this change
            $table->mediumText('description')->nullable(); //the exact comment of what was done
            $table->tinyInteger('priority')->default(5); //1->highest priority , 5->lowest priority
            $table->string('method')->nullable(); //example UsersController@index
            $table->string('action_type')->nullable(); //create , update , delete etc
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
