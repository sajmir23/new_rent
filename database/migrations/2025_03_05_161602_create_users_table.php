<?php

use App\Enums\LocalesEnum;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->index();
            $table->string('last_name')->nullable()->index();
            $table->string('email')->unique();
            $table->string('locale')->default(LocalesEnum::ENGLISH);
            $table->string('notes')->nullable();
            $table->string('address')->nullable();
            $table->string('google_id')->nullable();
            $table->tinyInteger('approved_google_login')->default(2); //1->no , 1->yes
            $table->foreignId('role_id')->nullable()->index()->references('id')->on('roles');
            $table->foreignId('company_id')->nullable()->index()->references('id')->on('companies');
            $table->tinyInteger('user_type')->index()->default(1); //1->system admin
            $table->integer('status')->default(1);  //1->active
            $table->string('phone_number')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('alert_login')->default(false);
            $table->dateTime('last_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
