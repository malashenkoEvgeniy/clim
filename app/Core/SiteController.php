<?php

namespace App\Core;

use App\Core\Modules\Languages\Models\Language;
use App\Core\ObjectValues\RouteObjectValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Seo, Route;

/**
 * Class SiteController
 *
 * @package App\Core
 */
class SiteController extends Controller
{

    /**
     * Sets links for other languages for the same page
     *
     * @param Model $model
     */
    protected function setOtherLanguagesLinks(Model $model): void
    {
        Language::otherLanguagesLinks($model);
    }

    protected function breadcrumb(string $title, ?string $routeName = null, array $routeParameters = []): void
    {
        if (!$routeParameters && !$routeName) {
            $routeParameters = Route::current()->parameters;
        }
        $routeName = $routeName ?? Route::currentRouteName();
        Seo::breadcrumbs()->add($title, RouteObjectValue::make($routeName, $routeParameters));
    }

    protected function meta(Model $model, ?string $text = null): void
    {
        Seo::site()->setFromModel($model);
        if ($text) {
            Seo::site()->setSeoText($text);
        }
    }

    protected function metaTemplate(string $templateAlias, array $variables = []): void
    {
        Seo::site()->setTemplate($templateAlias, $variables);
    }

    /**
     * @param $canonical
     */
    protected function canonical($canonical): void
    {
        Seo::site()->setCanonical($canonical);
    }


    protected function pageNumber(): void
    {
        // dd(explode('/page/1', (string)request()->fullUrl()));
        list(, $pageNumber) = array_pad(explode('/', (string)request()->pageQuery), 2, 1);
        $pageNumber = (int)$pageNumber;
        $this->setPageNumber($pageNumber);
    }

    /**
     * @param $pageNumber
     */
    protected function setPageNumber($pageNumber): void
    {
        Seo::site()->setPageNumber($pageNumber);
    }

    /**
     *  Hide description and keywords for page with filters and sortable
     */
    protected function hideDescriptionKeywords(): void
    {
        Seo::site()->setHideDescriptionKeywords(true);
    }

    protected function sameMeta(string $meta): void
    {
        $meta = __($meta);
        Seo::site()->set([
            'name' => $meta,
            'h1' => $meta,
            'title' => $meta,
        ]);
    }

}
