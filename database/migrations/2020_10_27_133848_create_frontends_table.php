<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrontendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frontends', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('logo')->nullable();
            $table->string('footer_text')->nullable();
            $table->mediumText('footer_address')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('fb_id')->nullable();
            $table->string('tw_id')->nullable();
            $table->string('insta_id')->nullable();
            $table->string('yt_id')->nullable();
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
        Schema::dropIfExists('frontends');
    }
}
