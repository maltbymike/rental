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
            $table->string('product_key');
            $table->string('part_number')->nullable();
            $table->unsignedInteger('por_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('quantity')->nullable();
            $table->char('type', 1);
            $table->unsignedInteger('manufacturer_id')->nullable();
            $table->string('model')->nullable();
            $table->string('header')->nullable();
            $table->boolean('inactive')->default(true);
            $table->boolean('hide_on_website')->default(false);
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
