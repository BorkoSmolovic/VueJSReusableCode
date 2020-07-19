<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvidentionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evidention_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('item_id')->unsigned()->nullable();
            $table->bigInteger('vehicle_id')->unsigned()->nullable();
            $table->decimal('value', 8,2);
            $table->bigInteger('evidention_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->boolean('isActive')->default(true);
            $table->timestamps();

            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
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
        Schema::dropIfExists('evidention_items');
    }
}
