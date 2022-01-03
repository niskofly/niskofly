<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBranchTableContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('contacts', function (Blueprint $table) {
            $table->boolean('is_branch')->default(0)->comment('Филиал');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('is_branch');
        });*/
    }
}
