<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug', 3)->unique();
            $table->boolean('default')->default(0)->comment('Язык по-умолчанию');
            $table->string('google_slug', 3)->nullable();
        }
        );
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (app()->environment() !== 'production') {
            Schema::dropIfExists('languages');
        }
    }
}
