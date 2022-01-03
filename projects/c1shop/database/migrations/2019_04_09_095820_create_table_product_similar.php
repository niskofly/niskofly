<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProductSimilar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('product_similar', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->integer('product_id')->unsigned()->comment('ID товара');
            $table->integer('similar_id')->unsigned()->comment('ID связанного товара');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::dropIfExists('product_similar');*/
    }
}
