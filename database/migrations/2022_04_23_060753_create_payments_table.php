<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string("trans_id")->unique()->nullable();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedBigInteger("order_id")->nullable();
            $table->string("trans_status")->default('INITIATED');
            $table->float("amount")->nullable();
            $table->string("description")->nullable();
            $table->string("stripe_payment_status")->nullable();
            $table->string("stripe_payment_intent")->nullable();
            $table->string("stripe_payment_currency")->nullable();
            $table->string("stripe_payment_id")->nullable();
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
        Schema::dropIfExists('payments');
    }
}
