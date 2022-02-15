<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community', function (Blueprint $table) {
            $table->id();
            $table->text('type');
            $table->text('icon');
            $table->text('color');
            $table->text('color_status');
            $table->text('title');
            $table->text('description');
            $table->text('location')->nullable();
            $table->integer('is_active')->default(1);
            $table->text("status_text");
            $table->text("status_color");
            $table->text("preview_link")->nullable();
            $table->text('formatted_adress')->nullable();
            $table->text("going_id")->nullable();
            $table->text('user_id');
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
        Schema::dropIfExists('community');
    }
}
