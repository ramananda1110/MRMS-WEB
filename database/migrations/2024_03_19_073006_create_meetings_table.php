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
            $table->foreignId('host_id')->constrained('users');
            $table->foreignId('co_host_id')->nullable()->constrained('users');
            $table->string('status')->default('pending'); // Use string for status
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
