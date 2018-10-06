<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('mode_id');
            $table->integer('order');
            $table->string('title');
            $table->string('url');
            $table->string('theme_color', 7);
            $table->binary('rows');
            $table->integer('limit')->default(4);
        });

        Schema::table('personal_feeds', function(Blueprint $table) {
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
        Schema::dropIfExists('personal_feeds');
    }
}
