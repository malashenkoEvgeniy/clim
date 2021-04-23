<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MailTemplateTranslates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_templates_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->text('text');
            $table->integer('row_id')->unsigned();
            $table->string('language', 3);
        
            $table->foreign('language')->references('slug')->on('languages')
                ->index('mail_tpl_translates_language_languages_slug')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('row_id')->references('id')->on('mail_templates')
                ->index('mail_tpl_translates_row_id_mail_tpl_id')
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
            Schema::table('mail_templates_translates', function (Blueprint $table) {
                $table->dropForeign('mail_tpl_translates_language_languages_slug');
                $table->dropForeign('mail_tpl_translates_row_id_mail_tpl_id');
            });
            Schema::dropIfExists('mail_templates_translates');
        }
    }
}
