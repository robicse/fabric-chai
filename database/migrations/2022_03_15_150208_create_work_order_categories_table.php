<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('work_order_product_id');
            $table->integer('category_id');
            $table->integer('sub_category_id')->nullable();
            $table->integer('sub_sub_category_id')->nullable();
            $table->integer('sub_sub_child_category_id')->nullable();
            $table->integer('sub_sub_child_child_category_id')->nullable();
            $table->integer('category_six_id')->nullable();
            $table->integer('category_seven_id')->nullable();
            $table->integer('category_eight_id')->nullable();
            $table->integer('category_nine_id')->nullable();
            $table->integer('category_ten_id')->nullable();
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
        Schema::dropIfExists('work_order_categories');
    }
}
