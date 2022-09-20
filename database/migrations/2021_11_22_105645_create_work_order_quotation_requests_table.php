<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderQuotationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_quotation_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('buyer_user_id');
            $table->bigInteger('seller_user_id');
            $table->bigInteger('work_order_product_id');
            $table->string('quantity');
            $table->double('unit_price');
            $table->double('total_price');
            $table->string('details');
            $table->integer('status');
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
        Schema::dropIfExists('work_order_quotation_requests');
    }
}
