<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setings', function (Blueprint $table) {
            $table->id();
            $table->string("site_address");
            $table->string("site_phone");
            $table->string("site_email");
            $table->string("site_name");
            $table->text("site_summary");
            $table->string("site_slogan");
            $table->string("site_facebook");
            $table->string("site_instegram");
            $table->string("site_tiktok");
            $table->string("site_youtube");
            $table->string("site_snapchate");
            $table->text("site_keywords");
            $table->text("site_description");
            $table->string("site_upper_logo");
            $table->string("site_lower_logo");
            $table->boolean("site_active")->default(true)->comment("0 meen sit is close and 1 meen sit is open");
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
        Schema::dropIfExists('setings');
    }
}
