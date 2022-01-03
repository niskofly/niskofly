<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('url');
            $table->text('mark')->nullable();
            $table->text('type')->nullable();
            $table->integer('active')->nullable();
            $table->integer('actual_price')->nullable();
            $table->integer('old_price')->nullable();
            $table->text('file_guide')->nullable();
            $table->text('file_price_list')->nullable();
            $table->text('certificates')->nullable();
            $table->mediumText('videos')->nullable();
            $table->text('photos');
            $table->integer('sort');
            $table->unsignedBigInteger('category_id')->nullable(false);
            $table->text('loading')->nullable();
            $table->text('width_area')->nullable();
            $table->text('performance')->nullable();
            $table->text('revers')->nullable();
            $table->text('action')->nullable();
            $table->text('photo')->nullable();
            $table->mediumText('description')->nullable();
            $table->longText('params')->nullable();
            $table->text('load_file')->nullable();
            $table->integer('in_stock')->nullable();
            $table->text('seo_key')->nullable();
            $table->text('seo_title')->nullable();
            $table->text('seo_description')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parts');
    }
}
