<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Features\Models\Feature;

class FeaturesTableStab extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('features', function (Blueprint $table) {
            $table->boolean('main')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        if (app()->environment() !== 'production') {
            Schema::table('features', function (Blueprint $table) {
                $table->dropColumn('main');
            });
        }
    }

}
