<?php

namespace App\Core\Modules\Languages\Controllers\Admin;

use App\Core\AdminController;
use App\Core\Modules\Languages\Models\Language;

/**
 * Class IndexController
 * This class controls languages list on the site
 *
 * @package App\Core\Modules\Languages\Controllers
 */
class IndexController extends AdminController
{
    
    /**
     * Languages list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $languages = array_values(config('languages', []));
        abort_unless($languages && is_array($languages) && count($languages) > 1, 404);
        usort($languages, function ($current, $next) {
            return $current->id <=> $next->id;
        });
        return view('languages::index', [
            'languages' => $languages,
        ]);
    }
    
    /**
     * Updates default language
     *
     * @param  Language $language
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    public function defaultLanguage(Language $language)
    {
        // Set new default language
        $language->setAsDefault();
        // Leave message and redirect back
        return $this->afterUpdate();
    }
    
}
