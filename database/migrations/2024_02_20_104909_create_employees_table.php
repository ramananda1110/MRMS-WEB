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
            $table->string('employee_id')->unique();
            $table->string('grade')->nullable();
            $table->string('name');
            $table->string('status')->nullable();
            $table->string('division')->nullable();
            $table->string('project_name')->nullable();
            $table->string('project_code')->nullable();
            $table->string('designation')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('email')->nullable();
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
