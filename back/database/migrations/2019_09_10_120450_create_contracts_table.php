<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contract_name');
            $table->bigInteger('partner_id')->unsigned();
            $table->date('dateFrom');
            $table->date('dateTo');
            $table->bigInteger('number_of_recordings');
            $table->bigInteger('recordings_remaining');
            $table->boolean('isActive')->default(true);
            $table->timestamps();
            $table->bigInteger('user_id')->unsigned();

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
        Schema::dropIfExists('contracts');
    }
}
