<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class BookingCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address');
            $table->string('city');
            $table->string('email');
            $table->string('phone');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });

        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('reserved_at');
            $table->integer('nb_invites');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->string('occasion');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reservations');
        Schema::drop('customers');
    }
}
