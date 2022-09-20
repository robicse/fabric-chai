<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipPackageOtherBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_package_other_benefits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_package_id');
            $table->string('market_strategic')->nullable();
            $table->string('rd_facilities')->nullable();
            $table->string('costing_facilities')->nullable();
            $table->integer('promotion_facilities')->nullable();
            $table->string('bank_loan_facilities')->nullable();
            $table->string('customer_acquisition_facilities')->nullable();
            $table->string('discount_offers')->nullable();
            $table->string('training_facility')->nullable();
            $table->string('ad_discounts')->nullable();
            $table->string('credit_facilities')->nullable();
            $table->string('loyalty_program')->nullable();
            $table->string('yarn_price_update')->nullable();
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
        Schema::dropIfExists('membership_package_other_benefits');
    }
}
