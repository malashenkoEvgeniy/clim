<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'roles', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('hidden')->default(false);
            $table->boolean('active')->default(true);
            $table->string('name');
            $table->string('alias')->unique();
            $table->timestamps();
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
            Schema::dropIfExists('roles');
        }
    }
}
