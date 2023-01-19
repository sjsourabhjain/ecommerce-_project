<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantCombinationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variant_combination_details', function (Blueprint $table) {
            $table->id();
            $table->integer("product_id")->default(0);
            $table->integer("pvc_id")->default(0);
            $table->integer("variant_id")->default(0);
            $table->string("variant_value")->default("");
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
        Schema::dropIfExists('product_variant_combination_details');
    }
}
