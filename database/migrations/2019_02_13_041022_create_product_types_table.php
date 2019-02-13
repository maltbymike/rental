<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_types', function (Blueprint $table) {
            $table->increments('id');
            $table->char('type_code', 1);
            $table->string('name');
            $table->timestamps();
        });

        DB::table('product_types')->insert([
            ['type_code' => 'S', 'name' => "Sales – Normal"],
            ['type_code' => 'M', 'name' => "Sales – Misc"],
            ['type_code' => 'W', 'name' => "Sales – Parts"],
            ['type_code' => 'T', 'name' => "Rental – Normal"],
            ['type_code' => 'V', 'name' => "Rental – Header"],
            ['type_code' => 'U', 'name' => "Rental – Usage Item"],
            ['type_code' => 'A', 'name' => "Rental – Accessory"],
            ['type_code' => 'K', 'name' => "Rental – Package"],
            ['type_code' => 'D', 'name' => "Rental – Dynamic Qty"],
            ['type_code' => 'E', 'name' => "Sales – Header"],
            ['type_code' => 'H', 'name' => "Rental – Hour Meter"],
            ['type_code' => 'F', 'name' => "Sales – Fractional Qty"],
            ['type_code' => 'I', 'name' => "Non Rental Asset"],
            ['type_code' => 'P', 'name' => "Sales – Percent of Rental"],
            ['type_code' => 'B', 'name' => "Sales – Labour Item"],
            ['type_code' => 'R', 'name' => "Rental – Miscellaneous"],
            ['type_code' => 'N', 'name' => "Rental – Coupon"],
            ['type_code' => 'O', 'name' => "Work Order Item"],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_type');
    }
}
