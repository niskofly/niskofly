<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionalFieldSeoFilter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('seo_filters', function (Blueprint $table) {
            $table->string('series')->nullable();
            $table->string('loading')->nullable();
            $table->string('width_area')->nullable();
            $table->string('performance')->nullable();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       /* Schema::table('seo_filters', function (Blueprint $table) {
            $table->dropColumn('series');
            $table->dropColumn('loading');
            $table->dropColumn('width_area');
            $table->dropColumn('performance');
        });*/
    }
}
