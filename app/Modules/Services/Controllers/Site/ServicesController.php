<?php

namespace App\Modules\Services\Controllers\Site;


use App\Core\Modules\SystemPages\Models\SystemPage;
use App\Core\SiteController;
use App\Modules\Services\Models\Service;
use App\Modules\Services\Models\ServicesRubric;
use Seo;

class ServicesController extends SiteController
{
    static $rubricsMainPage;

    public function __construct()
    {
        static::$rubricsMainPage = SystemPage::getByCurrent('slug', 'services');
    }

    public function index()
    {
        $this->meta(static::$rubricsMainPage->current, static::$rubricsMainPage->current->content);
        $this->setOtherLanguagesLinks(static::$rubricsMainPage);
        $services = Service::getList();
        $this->canonical(route('site.services'));
        return view('services::site.index', [
            'services' => $services,
        ]);
    }

    public function item(string $url)
    {
        $service = Service::getOneBySlug($url);
        abort_unless($service && $service->active, 404);

        $this->hideDescriptionKeywords();
        $this->canonical(route('site.service', ['url' => $service->current->slug]));
        $this->meta($service->current, $service->current->content);
        $this->breadcrumb(static::$rubricsMainPage->current->name, 'site.services');
        $this->breadcrumb($service->current->name, 'site.service',  ['url' => $service->current->slug]);
        $this->setOtherLanguagesLinks($service);
        return view('services::site.show', [
            'service' => $service,
        ]);
    }
}