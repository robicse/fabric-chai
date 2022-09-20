<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_reviews', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sender_user_id');
            $table->bigInteger('receiver_user_id');
            $table->bigInteger('work_order_product_id');
            $table->integer('rating')->default(0);
            $table->longText('comment')->nullable();
            $table->integer('status')->default(1);
            $table->integer('viewed')->default(0);
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
        Schema::dropIfExists('work_order_reviews');
    }
}
