<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Products\Models\ProductGroup;

class ProductsGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            
            $table->boolean('active')->default(true);
            $table->integer('position')->default(ProductGroup::DEFAULT_POSITION);
            $table->integer('brand_id')->unsigned()->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('feature_id')->unsigned()->nullable();
    
            $table->foreign('brand_id')->references('id')->on('brands')
                ->index('products_groups_brand_id_brands_id')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('categories')
                ->index('products_groups_category_id_categories_id')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('feature_id')->on('features')->references('id')
                ->index('products_groups_feature_id_features_id')
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
        Schema::table('products_groups', function (Blueprint $table) {
            $table->dropForeign('products_groups_brand_id_brands_id');
            $table->dropForeign('products_groups_category_id_categories_id');
            $table->dropForeign('products_groups_feature_id_features_id');
        });
        Schema::dropIfExists('products_groups');
    }
}
