<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string("name")->comment("this is event name");
            $table->timestamp("event_date")->comment("this is event data");
            $table->text("overview")->comment("this is overview about event");
            $table->text("full_description")->comment("this is full description about event and this is created with ck editor");
            $table->string("slug")->comment("this is slug whech we search us it");
            $table->string("image")->comment("this event image");
            $table->boolean("active")->comment("this event status");
            $table->text("page_keywords");
            $table->text("page_description");
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
        Schema::dropIfExists('events');
    }
}
