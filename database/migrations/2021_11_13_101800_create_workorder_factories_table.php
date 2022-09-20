<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkorderFactoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workorder_factories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('seller_id');
            $table->string('mill_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('machine_type')->nullable();
            $table->string('floor_condition')->nullable();
            $table->string('no_of_machine')->nullable();
            $table->string('no_of_worker')->nullable();
            $table->string('mill_address')->nullable();
            $table->string('production_capacity')->nullable();
            $table->integer('unit_id')->nullable();
            $table->string('deliver_time')->nullable();
            $table->string('factory_open_hour')->nullable();
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
        Schema::dropIfExists('workorder_factories');
    }
}
