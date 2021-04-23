<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdersStatusesTranslates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_statuses_translates', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            
            $table->integer('row_id')->unsigned();
            $table->string('language', 3);
    
            $table->foreign('language')->references('slug')->on('languages')
                ->index('orders_statuses_translates_language_languages_slug')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('row_id')->references('id')->on('orders_statuses')
                ->index('orders_statuses_translates_row_id_orders_statuses_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
            Schema::table('orders_statuses_translates', function (Blueprint $table) {
                $table->dropForeign('orders_statuses_translates_language_languages_slug');
                $table->dropForeign('orders_statuses_translates_row_id_orders_statuses_id');
            });
            Schema::dropIfExists('orders_statuses_translates');
        }
    }
}
