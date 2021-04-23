<?php

namespace App\Modules\News\Database\Seeds;

use App\Core\Modules\Languages\Models\Language;
use App\Modules\News\Models\News;
use App\Modules\SeoTemplates\Models\SeoTemplate;
use App\Modules\SeoTemplates\Models\SeoTemplateTranslates;
use Illuminate\Database\Seeder;
use Schema;

class SeoTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasTable('seo_templates')) {
            $seoTemplate = new SeoTemplate();
            $seoTemplate->alias = News::SEO_TEMPLATE_ALIAS;
            $seoTemplate->variables = [
                'name' => 'news::seo.template-variables.name',
                'published_at' => 'news::seo.template-variables.published_at',
            ];
            $seoTemplate->save();
    
            Language::all()->each(function (Language $language) use ($seoTemplate) {
                $translate = new SeoTemplateTranslates();
                $translate->name = 'Шаблон для новостей';
                $translate->h1 = '{{name}}';
                $translate->title = '{{name}}, {{published_at}}';
                $translate->keywords = '{{name}}';
                $translate->description = '{{name}}';
                $translate->language = $language->slug;
                $translate->row_id = $seoTemplate->id;
                $translate->save();
            });
        }
    }
}
