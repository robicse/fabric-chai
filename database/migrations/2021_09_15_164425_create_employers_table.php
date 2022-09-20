<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('seller_id');
            $table->string('industry_category_id')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('no_of_employee')->nullable();
            $table->string('salary_type')->nullable();
            $table->string('established_year')->nullable();
            $table->string('vat')->nullable();
            $table->string('nid')->nullable();
            $table->string('factory_certificate')->nullable();
            $table->string('fire_licence')->nullable();
            $table->string('membership_image')->nullable();
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
        Schema::dropIfExists('employers');
    }
}
