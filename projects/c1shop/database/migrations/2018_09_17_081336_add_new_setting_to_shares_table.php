<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewSettingToSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /* Schema::table('shares', function (Blueprint $table) {
            $table->boolean('is_pinned')->default(0);
            $table->string('new_design_image')->nullable();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       /* Schema::table('shares', function (Blueprint $table) {
            $table->dropColumn('is_pinned');
            $table->dropColumn('new_design_image');
        });*/
    }
}
