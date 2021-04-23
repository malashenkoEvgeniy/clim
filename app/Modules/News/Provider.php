<?php

namespace App\Modules\News;

use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\Modules\Languages\Models\Language;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\News\Models\NewsTranslates;
use App\Modules\News\Widgets\JsonLd;
use App\Modules\News\Widgets\News;
use App\Modules\News\Widgets\SameNews;
use Carbon\Carbon;
use CustomForm\Input;
use CustomMenu, CustomSettings, CustomRoles, Widget;
use App\Core\BaseProvider;
use App\Modules\News\Models\News as NewsModel;
use Illuminate\Database\Eloquent\Builder;

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
        $settings = CustomSettings::createAndGet('news', 'news::settings.group-name');
        $settings->add(
            Input::create('per-page')
                ->setLabel('news::settings.attributes.per-page')
                ->required(),
            ['required', 'integer', 'min:1']
        );
        $settings->add(
            Input::create('per-page-client-side')
                ->setLabel('news::settings.attributes.per-page-client-side')
                ->required(),
            ['required', 'integer', 'min:1']
        );
        // Register left menu block
        CustomMenu::get()->group()
            ->block('content', 'news::general.menu-block', 'fa fa-files-o')
            ->link('news::general.menu', RouteObjectValue::make('admin.news.index'))
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.news.edit'),
                RouteObjectValue::make('admin.news.create')
            );
        // Register role scopes
        CustomRoles::add('news', 'news::general.menu')->except(RoleRule::VIEW);
    }
    
    protected function afterBoot()
    {
        Widget::register(News::class, 'news');
        Widget::register(SameNews::class, 'same-news');
        Widget::register(JsonLd::class, 'news::json-ld');
    }
    
    public function initSitemap()
    {
        $items = [];
        NewsModel::with('current')->published()->active()->latest('published_at')->get()->each(function (NewsModel $news) use (&$items) {
            $items[] = [
                'name' => $news->current->name,
                'url' => $news->link,
            ];
        });
        return [[
            'name' => __('news::site.sitemap-news'),
            'url' => route('site.news'),
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
                'url' => url($prefix . route('site.news', [] , false), [], isSecure()),
            ];
            if($language->default){
                $default_language = $language->slug;
            }
        }

        NewsTranslates::whereHas('row', function (Builder $builder){
            $builder->where('active', true)->where('published_at', '<=', Carbon::now());
        })->get()->each(function (NewsTranslates $page) use (&$items, &$default_language) {
            $prefix = ($default_language === $page->language) ? '' : '/' . $page->language;
            $items[] = [
                'url' => url($prefix . route('site.news-inner', ['slug' => $page->slug], false), [], isSecure())
            ];
        });
        return $items;
    }
    
}
