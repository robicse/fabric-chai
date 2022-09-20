<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsCostPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_cost_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('user_type')->nullable();
            $table->string('payment_with')->nullable();
            $table->float('online_charge',8,2);
            $table->string('payment_status')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('dispatch_date')->nullable();
            $table->string('check_number')->nullable();
            $table->float('amount',8,2);
            $table->text('description')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('ssl_status')->nullable();
            $table->string('currency')->nullable();
            $table->string('amount_after_getaway_fee')->nullable();
            $table->longText('payment_details')->nullable();
            $table->string('date')->nullable();
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
        Schema::dropIfExists('sms_cost_payment_histories');
    }
}
