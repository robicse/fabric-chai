<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSslCommerzModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ssl_commerz_models', function (Blueprint $table) {
            $table->id();
            $table->string('user_type')->nullable();
            $table->bigInteger('order_id')->nullable();
            $table->string('tran_id')->nullable();
            $table->string('current_table_name')->nullable();
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
        Schema::dropIfExists('ssl_commerz_models');
    }
}
