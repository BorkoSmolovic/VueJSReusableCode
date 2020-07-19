<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvidentionWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evidention_workers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('evidention_id')->unsigned();
            $table->bigInteger('worker_type_id')->unsigned();
            $table->bigInteger('worker_id')->unsigned();
            $table->boolean('isActive')->default(true);
            $table->decimal('salary');
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('evidention_id')->references('id')->on('evidentions');
            $table->foreign('worker_id')->references('id')->on('workers');
            $table->foreign('worker_type_id')->references('id')->on('worker_types');
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
        Schema::dropIfExists('evidention_workers');
    }
}
