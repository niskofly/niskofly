<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewDesignFieldTableProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /* Schema::table('products', function (Blueprint $table) {
            $table->text('file_guide')->nullable();
            $table->text('file_price_list')->nullable();
            $table->text('file_kit_mounting')->nullable();
            $table->text('file_kit_service')->nullable();
            $table->text('file_kit_repair')->nullable();
            $table->text('certificates')->nullable();
            $table->mediumText('videos')->nullable();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('file_guide');
            $table->dropColumn('file_price_list');
            $table->dropColumn('file_kit_mounting');
            $table->dropColumn('file_kit_service');
            $table->dropColumn('file_kit_repair');
            $table->dropColumn('certificates');
            $table->dropColumn('videos');
        });*/
    }
}
