<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Stabilization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slideshow_simple_translates', function (Blueprint $table) {
            $table->dropColumn('row_1');
            $table->dropColumn('row_2');
            $table->dropColumn('row_3');
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
            Schema::table('slideshow_simple_translates', function (Blueprint $table) {
                $table->string('row_1')->nullable();
                $table->string('row_2')->nullable();
                $table->string('row_3')->nullable();
            });
        }
    }
}
