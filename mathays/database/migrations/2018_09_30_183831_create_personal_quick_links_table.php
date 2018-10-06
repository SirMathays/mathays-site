<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalQuickLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_quick_links', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('mode_id');
            $table->integer('order');
            $table->string('name');
            $table->string('url');
            $table->string('color', 10);
            $table->timestamps();
        });

        Schema::table('personal_quick_links', function(Blueprint $table) {
            $table->foreign('mode_id')->references('id')->on('personal_modes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_quick_links');
    }
}
