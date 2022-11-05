<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->on('users')->references('id');
            $table->string('order_no');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('address_type_name');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code');
            $table->float('sub_total');
            $table->integer('gst');
            $table->integer('amount_after_gst');
            $table->float('delivery_charge');
            $table->float('total');
            $table->integer('status');
            $table->string('order_status_id');
            $table->string('payment_status_id');
            $table->string('payment_mode_id');
            $table->dateTime('order_date');
            $table->string('user_lat')->nullable();
            $table->string('user_long')->nullable();
            $table->string('order_map_address')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
