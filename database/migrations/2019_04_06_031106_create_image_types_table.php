<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_types', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('slug');
          $table->timestamps();
        });

        DB::table('image_types')->insert([
            ['name' => "Header", 'slug' => 'header'],
            ['name' => 'Product', 'slug' => 'product']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_types');
    }
}
