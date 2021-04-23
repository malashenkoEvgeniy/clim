<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RolesRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'roles_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned()->nullable();
            $table->string('module')->comment('Current module namespace');
            $table->boolean('index')->default(false)->comment('List pages');
            $table->boolean('view')->default(false)->comment('View page if exists');
            $table->boolean('store')->default(false)->comment('Create new / Restore row');
            $table->boolean('update')->default(false)->comment('Update information (sortable, status, edit page etc.)');
            $table->boolean('delete')->default(false)->comment('Delete row');
            $table->timestamps();
            
            $table->foreign('role_id')->on('roles')->references('id')
                ->index('roles_rules_role_id_roles_id')
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
                'roles_rules', function (Blueprint $table) {
                $table->dropForeign('roles_rules_role_id_roles_id');
            }
            );
            Schema::dropIfExists('roles_rules');
        }
    }
}
