<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdersAddColumnsForDelivery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('city_ref')->nullable();
            $table->string('warehouse_ref')->nullable();
            $table->string('ttn')->nullable();
            $table->string('ttn_ref')->nullable();
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
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('city_ref');
                $table->dropColumn('warehouse_ref');
                $table->dropColumn('ttn');
                $table->dropColumn('ttn_ref');
            });
        }
    }
}
