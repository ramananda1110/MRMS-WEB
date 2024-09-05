<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained();
            $table->string('meeting_title');
            $table->date('start_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('host_id')->nullable(); 
            $table->integer('co_host_id')->nullable(); 
            $table->string('booking_type')->default('book'); // book, rechedule
            $table->string('booking_status')->default('pending'); // pending, cancel, completed, past, accept
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
}
