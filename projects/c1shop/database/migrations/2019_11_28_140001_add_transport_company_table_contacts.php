<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransportCompanyTableContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /* Schema::table('contacts', function (Blueprint $table) {
            $table->text('transport_company')->nullable()->comment('Транспортная компания');
            $table->boolean('published')->default(1);
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
            $table->dropColumn('transport_company');
            $table->dropColumn('published');
        });*/
    }
}
