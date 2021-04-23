<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Features\Models\Feature;

class FeaturesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('features', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(true);
            $table->boolean('in_filter')->default(true);
            $table->string('type')->default(Feature::TYPE_MULTIPLE);
            $table->integer('position')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        if (app()->environment() !== 'production') {
            Schema::dropIfExists('features');
        }
    }

}
