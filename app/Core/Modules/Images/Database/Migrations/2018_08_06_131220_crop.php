<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Crop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crop', function (Blueprint $table) {
            $table->increments('id');
            $table->string('x');
            $table->string('y');
            $table->string('width');
            $table->string('height');
            $table->integer('model_id')->index();
            $table->string('model_name')->index();
            $table->string('size')->index();
            $table->string('folder')->nullable();
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
            Schema::dropIfExists('crop');
        }
    }
}
