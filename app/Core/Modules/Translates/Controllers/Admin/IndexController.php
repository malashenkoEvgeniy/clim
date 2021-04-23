<?php

namespace App\Core\Modules\Translates\Controllers\Admin;

use App\Core\AdminController;
use App\Core\AjaxTrait;
use App\Core\Modules\Languages\Models\Language;
use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Support\Facades\Request;
use Seo;

/**
 * Class IndexController
 * This class controls languages list on the site
 *
 * @package App\Core\Modules\Languages\Controllers
 */
class IndexController extends AdminController
{
    use AjaxTrait;
    
    /**
     * IndexController constructor.
     */
    public function __construct()
    {
        Seo::breadcrumbs()->add('translates::seo.index');
    }

    /**
     * @param string $place
     * @param string $module
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(string $place, string $module = null)
    {
        Seo::meta()->setH1('translates::seo.index');

        if ($place === 'site') {
            $languages = Language::orderBy('name')->get()->keyBy('slug')->toArray();
        } elseif($place === 'admin') {
            $languages = config('langs.list-for-admin', []);
            asort($languages);
        } else {
            $place = null;
            $languages = config('langs.list-for-admin', []);
            Language::orderBy('name')->get()->each(function (Language $language) use (&$languages) {
                $languages[$language->slug ] = [
                    'name' => $language->name,
                ];
            });
            asort($languages);
        }

        $translates = Translate::getTranslates($place, array_keys($languages));
        $allTranslates = array_pull($translates, 'all-translates');
        $modules = array_keys($translates);
        if (in_array($module, $modules)) {
            $module = $module ?: array_get($modules, 0);
        } else {
            $module = count($modules) > 1 ? 'all-translates' : array_get($modules, 0);
        }

        return view('translates::index', [
            'languages' => $languages,
            'translates' => array_get($translates, $module, []),
            'allTranslates' => $allTranslates,
            'modules' => $modules,
            'place' => $place,
            'currentModule' => $module,
            'limit' => config('db.translates.per-page', 10),
        ]);
    }
    
    /**
     * @param Request $request
     * @param string $place
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $place)
    {
        if (Translate::setTranslate($place)) {
            return $this->successJsonAnswer();
        }
        return $this->errorJsonAnswer();
    }


    public function list()
    {
        $translates = Translate::getTranslatesList();

        return view('translates::list',[
            'translates' => $translates,
        ]);
    }
}
