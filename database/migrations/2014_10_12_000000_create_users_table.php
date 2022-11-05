<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role');
            $table->integer('mobile')->nullable();
            $table->string('user_image')->nullable();
            $table->integer('otp')->nullable();
            $table->integer('otp_expiration_time')->nullable();
            $table->tinyInteger('verified_otp')->nullable();
            $table->string('token')->nullable();
            $table->string('firebase_token')->nullable();
            $table->string('doc')->nullable();
            $table->string('doc_verified')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->rememberToken();
            $table->timestamps();
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
}
