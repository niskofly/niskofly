<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFiltersParamsTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('loading')->nullable();
            $table->text('width_area')->nullable();
            $table->text('performance')->nullable();
            $table->text('revers')->nullable();
            $table->text('action')->nullable();
            $table->text('below_type')->nullable()->comment('Под типы для финишного оборудования');
            $table->text('photo')->nullable();
            $table->mediumText('description')->nullable();
            $table->longText('params')->nullable();
            $table->text('load_file')->nullable();
            $table->integer('in_stock');
            $table->text('seo_key')->nullable();
            $table->text('seo_title')->nullable();
            $table->text('seo_description')->nullable();
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
            $table->dropColumn('loading');
            $table->dropColumn('width_area');
            $table->dropColumn('performance');
            $table->dropColumn('revers');
            $table->dropColumn('below_type');
            $table->dropColumn('photo');
            $table->dropColumn('revers');
            $table->dropColumn('description');
            $table->dropColumn('params');
            $table->dropColumn('load_file');
            $table->dropColumn('in_stock');
            $table->dropColumn('seo_key');
            $table->dropColumn('seo_title');
            $table->dropColumn('seo_description');
            $table->dropColumn('action');
        });
    }
}
