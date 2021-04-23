<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PromUaCategoriesUpgradeToRemote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories_prom_ua', function (Blueprint $table) {
            $table->renameColumn('prom_ua_id', 'remote_id');
            $table->string('system')->nullable();
            $table->rename('categories_remote');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories_remote', function (Blueprint $table) {
            $table->renameColumn('remote_id', 'prom_ua_id');
            $table->dropColumn('system');
            $table->rename('categories_prom_ua');
        });
    }
}
