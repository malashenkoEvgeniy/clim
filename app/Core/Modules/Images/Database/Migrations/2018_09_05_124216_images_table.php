<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imageable_class')->comment('Model name Catalog::class, Gallery::class etc.');
            $table->string('imageable_type')->index()->comment('Type of the image (Catalog::class, Gallery::class etc.)');
            $table->integer('imageable_id')->index()->comment('ID of the related row');
            $table->boolean('active')->default(true);
            $table->integer('position')->default(0);
            $table->string('name');
            $table->string('basename');
            $table->string('mime');
            $table->string('ext');
            $table->string('size');
            $table->text('information')->nullable();
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
        if (app()->environment() !== 'production') {
            Schema::drop('images');
        }
    }
}
