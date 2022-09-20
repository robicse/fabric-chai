<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('offer_id');
            $table->bigInteger('sender_user_id');
            $table->bigInteger('receiver_user_id');
            $table->string('title')->nullable();
            $table->string('message');
            $table->enum('message_charge_status',['Free', 'Charge Include'])->default('Free');
            $table->integer('message_charge_id');
            $table->float('cost_per_sms',8,2);
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
        Schema::dropIfExists('messages');
    }
}
