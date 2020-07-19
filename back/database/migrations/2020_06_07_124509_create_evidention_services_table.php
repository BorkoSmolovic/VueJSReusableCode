<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvidentionServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evidention_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('service_id')->unsigned();
            $table->bigInteger('evidention_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->boolean('isActive')->default(true);
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('evidention_id')->references('id')->on('evidentions');
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
        Schema::dropIfExists('evidention_services');
    }
}
