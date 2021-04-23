<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribeMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriber_mails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->text('text');
            $table->integer('count_emails');
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
            Schema::dropIfExists('subscriber_mails');
        }
    }
}
