<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsAvailabilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_availability', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->integer('product_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products')
                ->index('products_availability_product_id_products_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('user_id')->on('users')->references('id')
                ->index('products_availability_user_id_users_id')
                ->onUpdate('cascade')
                ->onDelete('set null');
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
            Schema::table('products_availability', function (Blueprint $table) {
                $table->dropForeign('products_availability_product_id_products_id');
                $table->dropForeign('products_availability_user_id_users_id');
            });
            Schema::dropIfExists('products_availability');
        }
    }
}
