<?php

namespace App\Modules\ProductsDictionary\Database\Seeds;

use App\Components\Settings\Models\Setting;
use App\Core\Modules\Languages\Models\Language;
use Illuminate\Database\Seeder;

class ProductDictionarySeeder extends Seeder
{
    const MODULE = 'settings';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::all()->each(function (Language $language) {
            $settingExists = Setting::whereGroup('products_dictionary')
                ->whereAlias($language->slug . '_title')
                ->exists();
            if (!$settingExists) {
                $setting = new Setting();
                $setting->group = 'products_dictionary';
                $setting->alias = $language->slug . '_title';
                $setting->value = '';
                $setting->save();
            }
        });
    
        $settingExists = Setting::whereGroup('products_dictionary')
            ->whereAlias('site_status')
            ->exists();
        if (!$settingExists) {
            $setting = new Setting();
            $setting->group = 'products_dictionary';
            $setting->alias = 'site_status';
            $setting->value = 0;
            $setting->save();
        }
    
        $settingExists = Setting::whereGroup('products_dictionary')
            ->whereAlias('select_status')
            ->exists();
        if (!$settingExists) {
            $setting = new Setting();
            $setting->group = 'products_dictionary';
            $setting->alias = 'select_status';
            $setting->value = 1;
            $setting->save();
        }
    }
}
