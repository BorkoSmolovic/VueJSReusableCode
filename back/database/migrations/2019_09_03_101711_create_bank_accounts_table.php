<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_number');
            $table->bigInteger('bank_id')->unsigned();
            $table->bigInteger('partner_id')->unsigned();
            $table->boolean('isActive')->default(true);
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('bank_id')->references('id')->on('banks');
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_accounts');
    }
}
