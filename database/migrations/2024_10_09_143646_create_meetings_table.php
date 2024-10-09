<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('room_id')->index('meetings_room_id_foreign');
            $table->string('meeting_title');
            $table->date('start_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('host_id')->nullable();
            $table->integer('co_host_id')->nullable();
            $table->string('booking_type')->default('book');
            $table->string('booking_status')->default('pending');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('meetings');
    }
};
