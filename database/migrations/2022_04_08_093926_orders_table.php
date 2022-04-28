<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrdersTable extends Migration
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
            $table->string('order_number')->unique();
            $table->string('user_id');
            $table->string('product_id')->nullable();
            $table->float('sub_total');
            $table->string('coupon')->nullable();
            $table->float('total_amount');
            $table->integer('quantity')->nullable();
            $table->float('delivery_charge')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->integer('payment_status')->default(0);
            $table->string('phone');
            $table->string('address');
            $table->string('shipping_type')->default(1);
            $table->unsignedBigInteger('status')->default(1);
            $table->foreign('status')->references('id')->on('order_status');
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
        Schema::drop('orders');
    }
}
