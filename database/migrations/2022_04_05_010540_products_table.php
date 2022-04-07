<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('description');
            $table->string('short_description')->nullable();
            $table->string('photo')->nullable();
            $table->float('price');
            $table->enum('stock_status',['outofstock','instock']);
            $table->float('offer_price')->nullable();
            $table->integer('quantity')->default(10)->nullable();
            $table->float('discount')->nullable();
            $table->enum('status', ['published', 'unpublished']);
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
        Schema::drop('products');
    }
}
