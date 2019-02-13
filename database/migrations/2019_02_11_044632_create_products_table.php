<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('part_number')->nullable();
            $table->unsignedInteger('por_num');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('quantity')->nullable();
            $table->char('type', 1);
            $table->decimal('2_hour', 8, 2);
            $table->decimal('4_hour', 8, 2);
            $table->decimal('daily', 8, 2);
            $table->decimal('weekly', 8, 2);
            $table->decimal('4_Week', 8, 2);
            $table->unsignedInteger('manufacturer_id')->nullable();
            $table->string('model')->nullable();
            $table->string('header')->nullable();
            $table->boolean('inactive')->default(true);
            $table->boolean('hide_on_website')->default(false);
            $table->decimal('weight', 8, 2);
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
        Schema::dropIfExists('products');
    }
}
