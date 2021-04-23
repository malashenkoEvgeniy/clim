<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminsRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'admins_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned()->nullable();
            $table->integer('admin_id')->unsigned()->nullable();
            $table->timestamps();
            
            $table->foreign('role_id')->on('roles')->references('id')
                ->index('admins_roles_role_id_roles_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('admin_id')->on('admins')->references('id')
                ->index('admins_roles_admin_id_admins_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
            Schema::table(
                'admins_roles', function (Blueprint $table) {
                $table->dropForeign('admins_roles_role_id_roles_id');
                $table->dropForeign('admins_roles_admin_id_admins_id');
            }
            );
            Schema::dropIfExists('admins_roles');
        }
    }
}
