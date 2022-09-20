<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('user_type');
            $table->string('name');
            $table->bigInteger('category_id');
            $table->bigInteger('sub_category_id')->nullable();
            $table->bigInteger('sub_sub_category_id')->nullable();
            $table->bigInteger('sub_sub_child_category_id')->nullable();
            $table->bigInteger('sub_sub_child_child_category_id')->nullable();
            $table->bigInteger('category_six_id')->nullable();
            $table->bigInteger('category_seven_id')->nullable();
            $table->bigInteger('category_eight_id')->nullable();
            $table->bigInteger('category_nine_id')->nullable();
            $table->bigInteger('category_ten_id')->nullable();
            $table->string('thumbnail_img')->default('uploads/products/thumbnail/product_default_thumbnail.png');
            $table->string('photos')->default('["uploads\/products\/photos\/product_default_img.png"]');
            $table->string('slug');
            $table->integer('published');
            $table->integer('featured');
            $table->integer('unit_id');
            $table->double('unit_price')->nullable();
            $table->integer('currency_id');
            $table->string('quantity');
            $table->longText('description')->nullable();
            $table->string('machine_type')->nullable();
            $table->string('pc_per_minute')->nullable();
            $table->string('pc_per_day')->nullable();
            $table->string('moq')->nullable();
            $table->string('lead_time')->nullable();
            $table->string('delivery_time')->nullable();
            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
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
        Schema::dropIfExists('work_order_products');
    }
}
