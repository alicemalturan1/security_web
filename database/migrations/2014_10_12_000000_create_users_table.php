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
            $table->string('username')->unique();
            $table->integer("is_admin")->default(0);
            $table->integer("is_client")->default(0);
            $table->integer('is_worker')->default(0);
            $table->text("notif_token")->nullable();
            $table->text('notif_platform')->nullable();
            $table->text("avatar")->nullable();
            $table->text("api_token")->rand;
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text("name_surname")->nullable();
            $table->text("phone_number")->nullable();
            $table->text("about")->nullable();
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
