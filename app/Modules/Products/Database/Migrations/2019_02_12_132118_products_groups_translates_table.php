<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Products\Models\Product;

class ProductsGroupsTranslatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_groups_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('row_id')->unsigned();
            $table->string('language', 3);
            $table->string('name');
            $table->text('text')->nullable();
    
            $table->foreign('language')->references('slug')->on('languages')
                ->index('pgt_language_languages_slug')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('row_id')->references('id')->on('products_groups')
                ->index('pgt_modifications_row_id_products_groups_id')
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
        Schema::table('products_groups_translates', function (Blueprint $table) {
            $table->dropForeign('pgt_language_languages_slug');
            $table->dropForeign('pgt_modifications_row_id_products_groups_id');
        });
        Schema::dropIfExists('products_groups_translates');
    }
}
