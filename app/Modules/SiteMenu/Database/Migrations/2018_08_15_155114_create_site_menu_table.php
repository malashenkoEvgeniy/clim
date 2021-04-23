<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(false);
            $table->boolean('noindex')->default(false);
            $table->boolean('nofollow')->default(false);
            $table->string('place');
            $table->integer('position')->default(0);
            
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
            Schema::dropIfExists('site_menu');
        }
    }
}
