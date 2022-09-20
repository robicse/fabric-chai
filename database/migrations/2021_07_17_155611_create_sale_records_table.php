<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_records', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('seller_user_id');
            $table->bigInteger('buyer_user_id');
            $table->bigInteger('product_id');
            $table->bigInteger('product_bid_id');
            $table->double('amount')->nullable();
            $table->string('payment_status')->nullable();
            $table->integer('sale_status')->nullable();
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
        Schema::dropIfExists('sale_records');
    }
}
