<?php

namespace App\Core\Modules\Languages\Database\Seeds;

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [];
        foreach (explode(';', env('LANGUAGES', 'Русский,ru,1')) as $lang) {
            $languages[] = explode(',', $lang);
        }
        foreach ($languages AS $lang) {
            $model = new \App\Core\Modules\Languages\Models\Language();
            $model->name = $lang[0];
            $model->slug = $lang[1];
            $model->default = (bool)$lang[2];
            $model->save();
        }
    }
}
