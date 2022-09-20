<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderSaleRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_sale_records', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('seller_user_id');
            $table->bigInteger('buyer_user_id');
            $table->bigInteger('work_order_product_id');
            $table->bigInteger('work_order_bid_id');
            $table->double('amount');
            $table->double('commission');
            $table->double('vat');
            $table->double('admin_commission');
            $table->string('type');
            $table->string('payment_status');
            $table->string('invoice_code');
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
        Schema::dropIfExists('work_order_sale_records');
    }
}
