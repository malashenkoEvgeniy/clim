<?php

namespace App\Modules\SiteMenu\Controllers\Admin;

use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\SiteMenu\Forms\SiteMenuForm;
use App\Modules\SiteMenu\Models\SiteMenu;
use Seo, Route;
use App\Modules\SiteMenu\Requests\SiteMenuRequest;

class SiteMenuController extends AdminController
{
    public function __construct()
    {
        if (Route::current()) {
            Seo::breadcrumbs()->add(
                'site_menu::seo.index',
                RouteObjectValue::make(
                    'admin.site_menu.index', [
                        'place' => Route::current()->parameter('place'),
                    ]
                )
            );
        }
    }
    
    /**
     * Register widgets with buttons
     */
    private function registerButtons()
    {
        // Create new site menu button
        $this->addCreateButton('admin.site_menu.create', ['place' => Route::current()->parameter('place')]);
    }
    
    /**
     * Site menu sortable list
     *
     * @param  string $place
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(string $place)
    {
        // Set page buttons on the top of the page
        $this->registerButtons();
        // Set h1
        Seo::meta()->setH1('site_menu::seo.' . $place);
        // Get site menu
        $siteMenu = SiteMenu::tree($place);
        // Return view list
        return view('site_menu::admin.index', [
            'siteMenus' => $siteMenu,
            'depth' => $place == SiteMenu::PLACE_FOOTER ? 1 : 2,
        ]);
    }
    
    /**
     * Create new element page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function create()
    {
        // Breadcrumb
        Seo::breadcrumbs()->add('site_menu::seo.create');
        // Set h1
        Seo::meta()->setH1('site_menu::seo.create');
        // Javascript validation
        $this->jsValidation(new SiteMenuRequest());
        // Return form view
        return view(
            'site_menu::admin.create', [
                'form' => SiteMenuForm::make(),
            ]
        );
    }
    
    /**
     * Create page in database
     *
     * @param  SiteMenuRequest $request
     * @param  string $place
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(SiteMenuRequest $request, string $place)
    {
        $siteMenu = (new SiteMenu);
        // Create new menu item
        if ($message = $siteMenu->createRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterStore(['id' => $siteMenu->id, 'place' => $place]);
    }
    
    /**
     * Update element page
     *
     * @param  string $place
     * @param  SiteMenu $siteMenu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(string $place, SiteMenu $siteMenu)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($siteMenu->current->name ?? 'site_menu::seo.edit');
        // Set h1
        Seo::meta()->setH1('site_menu::seo.edit');
        // Javascript validation
        $this->initValidation((new SiteMenuRequest())->rules());
        // Return form view
        return view(
            'site_menu::admin.update', [
                'object' => $siteMenu,
                'form' => SiteMenuForm::make($siteMenu),
            ]
        );
    }
    
    /**
     * Update page in database
     *
     * @param  SiteMenuRequest $request
     * @param  SiteMenu $siteMenu
     * @param  string $place
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(SiteMenuRequest $request, string $place, SiteMenu $siteMenu)
    {
        // Update existed menu item
        if ($message = $siteMenu->updateRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterUpdate(['id' => $siteMenu->id, 'place' => $place]);
    }
    
    /**
     * Totally delete page from database
     *
     * @param  SiteMenu $siteMenu
     * @param  string $place
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(string $place, SiteMenu $siteMenu)
    {
        // Delete menu item
        $siteMenu->forceDelete();
        // Do something
        return $this->customRedirect('admin.site_menu.index', ['place' => $place], 'admin.messages.data-destroyed');
    }
    
}
