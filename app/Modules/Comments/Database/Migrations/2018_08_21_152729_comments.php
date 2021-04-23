<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Comments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('commentable_type')->comment('Type of the comment (catalog, reviews etc.)');
            $table->integer('commentable_id')->nullable()->comment('ID of the related row');
            $table->integer('user_id')->unsigned()->nullable()->comment('ID of the user');
            $table->string('name')->nullable()->comment('Client name');
            $table->text('comment')->comment('Client comment');
            $table->string('email')->comment('Client email');
            $table->tinyInteger('mark')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamp('published_at')->useCurrent();
            $table->timestamps();
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
            Schema::drop('comments');
        }
    }
}
