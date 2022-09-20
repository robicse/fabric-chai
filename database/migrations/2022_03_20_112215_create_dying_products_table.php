<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDyingProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dying_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id');
            $table->bigInteger('dying_category_id');
            $table->bigInteger('dying_sub_category_id')->nullable();
            $table->string('product_of_fabric')->nullable();
            $table->string('quantity')->nullable();
            $table->string('color')->nullable();
            $table->string('fabrics_construction')->nullable();
            $table->string('fabrics_composition')->nullable();
            $table->string('grey_width')->nullable();
            $table->string('finished_width')->nullable();
            $table->string('color_test_parameter')->nullable();
            $table->string('rubbing')->nullable();
            $table->string('tearing_strange')->nullable();
            $table->string('shining_receive')->nullable();
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
        Schema::dropIfExists('dying_products');
    }
}
