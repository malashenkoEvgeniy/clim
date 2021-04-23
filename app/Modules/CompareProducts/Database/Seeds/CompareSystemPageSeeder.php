<?php

namespace App\Modules\CompareProducts\Database\Seeds;

use App\Core\Modules\Languages\Models\Language;
use App\Core\Modules\SystemPages\Models\SystemPage;
use App\Core\Modules\SystemPages\Models\SystemPageTranslates;
use Illuminate\Database\Seeder;

class CompareSystemPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create main page
        $systemPage = new SystemPage();
        $systemPage->save();
        Language::all()->each(function (Language $language) use ($systemPage) {
            $translate = new SystemPageTranslates();
            $translate->slug = 'compare';
            $translate->language = $language->slug;
            $translate->row_id = $systemPage->id;
            $translate->name = 'Comparing';
            $translate->save();
        });
    }
}
