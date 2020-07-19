<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvidentionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evidentions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('event_name');
            $table->date('date');
            $table->string('description')->nullable();
            $table->boolean('is_commercial')->nullable();
            $table->boolean('isActive')->default(true);
            $table->bigInteger('city_id')->nullable()->unsigned();
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->bigInteger('contract_id')->unsigned();
            $table->string('invoice')->nullable();
            $table->double('net')->unsigned();
            $table->double('rebate')->unsigned();
            $table->double('net_rebate')->unsigned();
            $table->double('vat')->unsigned();
            $table->double('gross')->unsigned();
            $table->timestamps();

            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->foreign('city_id')->references('id')->on('cities');
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
        Schema::dropIfExists('evidentions');
    }
}
