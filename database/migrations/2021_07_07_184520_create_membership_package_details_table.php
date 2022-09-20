<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipPackageDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_package_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_package_id');
            $table->string('buy')->nullable();
            $table->string('sell')->nullable();
            $table->float('commission',8,2);
            $table->string('job')->nullable();
            $table->integer('free_sms')->nullable();
            $table->string('work_order')->nullable();
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
        Schema::dropIfExists('membership_package_details');
    }
}
