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
            $table->string('full_name')->default("");
            $table->integer('role_id')->default('0');
            $table->string('email')->nullable()->default("");
            $table->string('mob_no')->default("");
            $table->timestamp('email_verified_at')->nullable();
            $table->string('status')->default('0');
            $table->integer('otp')->default('0');
            $table->integer('is_otp_verified')->default('0');
            $table->string('password');
            $table->text('token')->nullable();
            $table->integer('is_logged_in')->default(0);
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
