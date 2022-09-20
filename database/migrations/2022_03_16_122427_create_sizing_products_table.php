<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSizingProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sizing_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id');
            $table->string('total_length')->nullable();
            $table->string('yarn_count')->nullable();
            $table->string('yarn_csp')->nullable();
            $table->string('ipi')->nullable();
            $table->string('lengths_of')->nullable();
            $table->string('price')->nullable();
            $table->string('warping_lengths')->nullable();
            $table->string('sizing_lengths')->nullable();
            $table->string('wastage_percentage')->nullable();
            $table->string('gera')->nullable();
            $table->string('sizing_time')->nullable();
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
        Schema::dropIfExists('sizing_products');
    }
}
