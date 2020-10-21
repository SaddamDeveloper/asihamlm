<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhotoToMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('photo')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ac_holder_name')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('account_no')->nullable();
            $table->string('pan_card')->nullable();
            $table->string('adhar_card')->nullable();
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
