<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('wallet_id')->nullable();
            $table->string('user_id')->nullable();
            $table->tinyInteger('transaction_type')->comment('1=Cr, 2=Dr')->nullable();
            $table->double('amount', 10, 2)->default(0);
            $table->double('total_amount', 10, 2)->default(0);
            $table->mediumText('comment')->nullable();
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
        Schema::dropIfExists('wallet_histories');
    }
}
