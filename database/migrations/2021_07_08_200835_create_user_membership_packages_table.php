<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMembershipPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_membership_packages', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('user_type')->nullable();
            $table->foreignId('membership_package_id');
            $table->string('invoice_no')->nullable();
            $table->string('membership_activation_date')->nullable();
            $table->string('membership_expired_date')->nullable();
            $table->string('payment_status')->nullable();
            $table->float('amount',8,2)->nullable();
            $table->string('payment_type')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('ssl_status')->nullable();
            $table->string('currency')->nullable();
            $table->timestamps();
            $table->foreign('membership_package_id')->references('id')->on('membership_packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_membership_packages');
    }
}
