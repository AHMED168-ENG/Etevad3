<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string("title")->comment("this is news title");
            $table->timestamp("news_date")->comment("this is news data");
            $table->text("full_description")->comment("this is full description about news and this is created with ck editor");
            $table->string("slug")->comment("this is slug whech we search us it");
            $table->string("image")->comment("this news image");
            $table->boolean("active")->comment("this news status");
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
        Schema::dropIfExists('news');
    }
}
