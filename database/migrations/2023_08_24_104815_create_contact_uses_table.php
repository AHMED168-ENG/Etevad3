<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_uses', function (Blueprint $table) {
            $table->id();
            $table->string("name")->comment("this is visetor name");
            $table->string("email")->comment("this is visetor email");
            $table->integer("age")->comment("this is visetor age");
            $table->string("phone")->comment("this is visetor phone");
            $table->string("title")->comment("this is message title");
            $table->text("message")->comment("this is message content");
            $table->boolean("is_seen")->comment("this is message seen 0 meen not seen and 1 meen seen")->default(false);
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
        Schema::dropIfExists('contact_uses');
    }
}
