<?php

namespace App\Modules\Articles;

use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\Modules\Languages\Models\Language;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Articles\Models\ArticleTranslates;
use App\Modules\Articles\Widgets\JsonLd;
use App\Modules\Articles\Widgets\LastArticles;
use CustomForm\Input;
use Illuminate\Database\Eloquent\Builder;
use Widget, CustomMenu, CustomSettings, CustomRoles;
use App\Core\BaseProvider;
use App\Modules\Articles\Models\Article as ArticleModel;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\Index
 */
class Provider extends BaseProvider
{
    
    /**
     * Set custom presets
     */
    protected function presets()
    {
    }
    
    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        // Register module configurable settings
        $settings = CustomSettings::createAndGet('articles', 'articles::settings.group-name');
        $settings->add(
            Input::create('per-page')->setLabel('articles::settings.attributes.per-page'),
            ['required', 'integer', 'min:1']
        );
        $settings->add(
            Input::create('per-page-client-side')
                ->setLabel('articles::settings.attributes.per-page-client-side')
                ->required(),
            ['required', 'integer', 'min:1']
        );
        // Register left menu block
        CustomMenu::get()->group()->block('content', 'articles::general.menu-block', 'fa fa-files-o')
            ->link('articles::general.menu', RouteObjectValue::make('admin.articles.index'))
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.articles.edit'),
                RouteObjectValue::make('admin.articles.create')
            );
        // Register role scopes
        CustomRoles::add('articles', 'articles::general.menu')->except(RoleRule::VIEW);
    }
    
    protected function afterBoot()
    {
        Widget::register(LastArticles::class, 'articles::last');
        Widget::register(JsonLd::class, 'articles::json-ld');
    }
    
    public function initSitemap()
    {
        $items = [];
        ArticleModel::with('current')->active()->latest('id')->get()->each(function (ArticleModel $article) use (&$items) {
            $items[] = [
                'name' => $article->current->name,
                'url' => $article->link,
            ];
        });
        return [[
            'name' => __('articles::site.sitemap-articles'),
            'url' => route('site.articles'),
            'items' => $items,
        ]];
    }


    public function initSitemapXml()
    {
        $languages = config('languages', []);
        $default_language = null;
        /** @var Language $language */
        foreach($languages as $language){
            $prefix = $language->default ? '' : '/'.$language->slug;
            $items[] = [
                'url' => url($prefix . route('site.articles', [], false), [], isSecure()),
            ];
            if($language->default){
                $default_language = $language->slug;
            }
        }
        ArticleTranslates::whereHas('row', function (Builder $builder){
            $builder->where('active', true);
        })->get()->each(function (ArticleTranslates $page) use (&$items, &$default_language) {
            $prefix = ($default_language === $page->language) ? '' : '/' . $page->language;
            $items[] = [
                'url' => url($prefix . route('site.articles-inner', ['slug' => $page->slug], false), [], isSecure()),
            ];
        });

        return $items;
    }
    
}
