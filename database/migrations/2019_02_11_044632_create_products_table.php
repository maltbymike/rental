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
            $table->string('key')->nullable();
            $table->unsignedInteger('por_num');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->decimal('sell_price')->nullable();
            $table->unsignedInteger('type');
            $table->unsignedInteger('manufacturer_id')->nullable();
            $table->string('model')->nullable();
            $table->date('purchased_date')->nullable();
            $table->date('sold_date')->nullable();
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
