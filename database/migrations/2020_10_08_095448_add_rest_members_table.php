<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRestMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('sponsor_id')->nullable();
            $table->string('login_id')->unique();
            $table->tinyInteger('leg')->comment('1=Left, 2=Right')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('pin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            //
        });
    }
}
