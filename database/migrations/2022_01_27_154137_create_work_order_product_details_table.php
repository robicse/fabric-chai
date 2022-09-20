<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_product_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('work_order_product_id');
            $table->bigInteger('machine_type_id');
            $table->bigInteger('no_of_machines');
            $table->string('pc_per_day');
            $table->string('total_pc_per_day');
            $table->string('moq');
            $table->string('max_oq');
            $table->string('production_time');
            $table->string('finishing_time');
            $table->string('delivery_time');
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
        Schema::dropIfExists('work_order_product_details');
    }
}
