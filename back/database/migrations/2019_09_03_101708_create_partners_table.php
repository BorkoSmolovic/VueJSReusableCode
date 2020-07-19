<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('pib')->nullable();
            $table->string('pdv')->nullable();
//            $table->string('pin')->nullable();
            $table->boolean('isActive')->default(true);
            $table->string('note')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->bigInteger('partner_type_id')->nullable()->unsigned();
            $table->bigInteger('city_id')->nullable()->unsigned();
            $table->bigInteger('user_id')->unsigned();


            //References
            $table->foreign('partner_type_id')->references('id')->on('partner_types');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('user_id')->references('id')->on('users');
//
        });


        //add foreign key to table users for partner_id
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('partner_id')->references('id')->on('partners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partners');
    }
}
