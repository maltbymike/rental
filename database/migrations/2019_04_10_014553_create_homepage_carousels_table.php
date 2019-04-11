<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomepageCarouselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homepage_carousels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename');
            $table->string('title')->nullable();
            $table->string('caption')->nullable();
            $table->string('button_text')->nullable();
            $table->string('link_to')->nullable();
            $table->boolean('inactive')->default(false);
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
        Schema::dropIfExists('homepage_carousels');
    }
}
