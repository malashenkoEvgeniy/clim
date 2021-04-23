<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsDictionaryRelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_dictionary_related', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dictionary_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->timestamps();

            $table->foreign('dictionary_id')->references('id')->on('products_dictionary')
                ->index('products_dictionary_related_dictionary_id_products_dictionary_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('group_id')->references('id')->on('products')
                ->index('products_dictionary_related_group_id_products_id')
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
        Schema::dropIfExists('products_dictionary_related');
    }
}
