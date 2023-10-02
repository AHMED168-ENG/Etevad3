<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutUsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_uses', function (Blueprint $table) {
            $table->id();
            $table->text("description");
            $table->text("vision");
            $table->text("message");
            $table->string("strategic_one_title");
            $table->text("strategic_one_content");
            $table->string("strategic_tow_title");
            $table->text("strategic_tow_content");
            $table->string("strategic_three_title");
            $table->text("strategic_three_content");
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
        Schema::dropIfExists('about_uses');
    }
}
