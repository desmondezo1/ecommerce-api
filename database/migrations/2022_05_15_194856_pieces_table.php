<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PiecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('piecesController', function (Blueprint $table) {
            $table->id();
            $table->string("product_id")->nullable();
            $table->string("title")->nullable();

            $table->unsignedBigInteger('category_id')->nullable();
//            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('description');
            $table->string('short_description')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
//            $table->foreign('partner_id')->references('id')->on('partners');
            $table->float('price')->nullable();
            $table->enum('stock_status',['outofstock','instock'])->default('instock');
            $table->float('offer_price')->nullable();
            $table->integer('instock_quantity')->default(10)->nullable();
            $table->float('discount')->nullable();
            $table->enum('status', ['published', 'unpublished'])->default('published');
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
        Schema::drop('piecesController');
    }
}
