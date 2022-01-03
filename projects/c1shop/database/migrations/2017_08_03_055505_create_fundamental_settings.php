<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundamentalSettings extends Migration
{
        /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('fundamental_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->comment('Человеческое название настройки/параметра. Например "Email-ы для оповещений"');
            $table->string('var', 50)->comment('параметр, на который завязаться в коде. Изменять его уже нельзя ибо пото искать все вхождения в код.');
            $table->string('value', 254)->comment('Значение параметра (список почт, цифровое значение и тп.)');
            $table->string('description', 254)->comment('Описание параметра для вывода в админке в качестве подказки');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fundamental_settings');
    }
}
