<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('message');
            $table->bigInteger('sender_user_id');
            $table->bigInteger('total_candidate');
            $table->bigInteger('total_sms_sent');
            $table->enum('message_charge_status',['Free', 'Charge Include'])->default('Free');
            $table->integer('message_charge_id');
            $table->float('cost_per_sms',8,2);
            $table->float('total_cost_sms',8,2);
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
        Schema::dropIfExists('offers');
    }
}
