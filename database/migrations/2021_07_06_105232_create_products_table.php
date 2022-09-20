<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->bigInteger('user_id');
            $table->string('type');
            $table->string('name');
            $table->foreignId('category_id');
            $table->foreignId('sub_category_id')->nullable();
            $table->foreignId('sub_sub_category_id')->nullable();
            $table->foreignId('sub_sub_child_category')->nullable();
            $table->foreignId('sub_sub_child_child_category_id')->nullable();
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
            $table->string('quantity')->nullable();
            $table->integer('unit_id')->nullable();
            $table->float('unit_price',8,2);
            $table->integer('currency_id')->nullable();
            $table->float('expected_price',8,2);
            $table->string('photos')->nullable();
            $table->string('thumbnail_img')->nullable();
            $table->integer('published')->nullable();
            $table->integer('featured_product')->nullable();
            $table->double('rating')->default(0);
            $table->string('bid_status')->default('Pending');
            $table->string('delivery_status')->default('Pending');
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
        Schema::dropIfExists('products');
    }
}
