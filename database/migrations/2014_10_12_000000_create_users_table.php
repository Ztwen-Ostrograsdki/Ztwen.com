<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('new_email')->nullable()->default(null);
            $table->string('role')->enum('user', ['admin', 'simple', 'refused', 'authorized', 'master'])->default('user');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('current_photo')->nullable();
            $table->string('token')->nullable()->default(null);
            $table->boolean('blocked')->nullable()->default(false);
            $table->string('email_verified_token')->nullable()->default(null);
            $table->string('new_email_verified_token')->nullable()->default(null);
            $table->string('reset_password_token')->nullable()->default(null);
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
