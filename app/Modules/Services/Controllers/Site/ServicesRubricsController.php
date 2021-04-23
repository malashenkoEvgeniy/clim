<?php

namespace App\Modules\Services\Controllers\Site;

use App\Core\Modules\SystemPages\Models\SystemPage;
use App\Core\SiteController;
use App\Modules\Services\Models\Service;
use App\Modules\Services\Models\ServicesRubric;
use App\Widgets\Site\SeoBlock;
use http\Env\Request;

class ServicesRubricsController extends SiteController
{
    static $rubricsMainPage;

    /**
     * ServiceRubrics constructor.
     */
    public function __construct()
    {
        static::$rubricsMainPage = SystemPage::getByCurrent('slug', 'services');
        abort_unless(static::$rubricsMainPage && static::$rubricsMainPage->exists, 404);
    }
    
    /**
     * ServicesRubrics list page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->meta(static::$rubricsMainPage->current, static::$rubricsMainPage->current->content);
        $this->setOtherLanguagesLinks(static::$rubricsMainPage);
        //ServicesRubric::rubric()->addMainCategoriesPageBreadcrumb(static::$rubricsMainPage->current->name);
        $rubrics = ServicesRubric::getList();
        $this->canonical(route('site.services-rubrics'));
        return view('services::site.index', [
            'servicesRubrics' => $rubrics,
        ]);
    }
    public function show(string $slug)
    {
        $rubric = ServicesRubric::getByCurrent('slug', $slug);
        $services = Service::getByParent($rubric->id);
        $this->canonical(route('site.services-rubric', ['slug' => $slug]));
        $this->meta($rubric->current, $rubric->current->content);
        $this->breadcrumb(static::$rubricsMainPage->current->name, 'site.services-rubrics');
        $this->breadcrumb($rubric->current->name, 'site.services-rubric');
        $this->setOtherLanguagesLinks($rubric);
        return view('services::site.index-rubrics', [
            'services' => $services,
            'rubric' => $rubric,
        ]);
    }
}