<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchivementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achivements', function (Blueprint $table) {
            $table->id();
            $table->string("title")->comment("this field about title ");
            $table->text("content")->comment("this field about achive ment content ");
            $table->date("achivement_date")->comment("this field about achivement date");
            $table->string("achivement_kind")->comment("this field about achivement kind like global yeare 1 meen robotes and 2 meen Wireless sports");
            $table->string("achivement_image")->comment("this field about achivement image");
            $table->string("achivement_icon")->comment("this field about achivement icon");
            $table->string("slug")->comment("this is slug use for ceo");
            $table->string("achivement_category")->comment("1 meen robote 2 meen wireless sports");
            $table->boolean("active")->comment("this field about achivement status");
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
        Schema::dropIfExists('achivements');
    }
}
