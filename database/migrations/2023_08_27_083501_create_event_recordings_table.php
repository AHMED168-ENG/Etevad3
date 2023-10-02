<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventRecordingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_recordings', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->integer("age");
            $table->string("email");
            $table->string("mobile");
            $table->foreignId("event_id")->references("id")->on("events")->onDelete("cascade");
            $table->boolean("is_seen")->default(false);
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
        Schema::dropIfExists('event_recordings');
    }
}
