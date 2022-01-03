<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeFieldToBrochuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('brochures', function (Blueprint $table) {
            $table->integer('type_id')->nullable()->comment('Тип документа');
        });
        Schema::table('brochure_types', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('name')->comment('Название');
            $table->collation('utf8mb4_general_ci');
            $table->engine('InnoDB');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('brochures', function (Blueprint $table) {
            $table->dropColumn('type_id');
        });
        Schema::dropIfExists('brochure_types');*/
    }
}
