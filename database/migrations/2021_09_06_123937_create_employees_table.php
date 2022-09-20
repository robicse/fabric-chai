<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->integer('current_job_status')->default(0);
            $table->integer('verification_status')->default(0);
            $table->bigInteger('user_id');
            $table->integer('division_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->string('upazila');
            $table->string('union');
            $table->string('village_or_area');
            $table->string('marital_status');
            $table->string('age');
            $table->string('gender');
            $table->string('nid_front_side')->nullable();
            $table->string('nid_back_side')->nullable();
            $table->string('employee_pic')->nullable();
            $table->double('current_salary')->nullable();
            $table->double('expected_salary')->nullable();
            $table->string('joining_duration')->nullable();
            $table->string('experience')->nullable();
            $table->integer('industry_category_id')->nullable();
            $table->integer('industry_sub_category_id')->nullable();
            $table->integer('industry_employee_type_id')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
