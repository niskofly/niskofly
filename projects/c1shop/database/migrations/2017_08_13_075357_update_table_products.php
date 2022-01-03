<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('mark')->nullable();
            $table->text('type')->nullable();
            $table->integer('active')->nullable();
            $table->integer('actual_price')->nullable();
            $table->integer('old_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('mark');
            $table->dropColumn('type');
            $table->dropColumn('active');
            $table->dropColumn('actual_price');
            $table->dropColumn('old_price');
        });
    }
}
