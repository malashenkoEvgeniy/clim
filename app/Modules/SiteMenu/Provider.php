<?php

namespace App\Modules\SiteMenu;

use App\Components\SiteMenu\Link;
use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\ObjectValues\LinkObjectValue;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\SiteMenu\Models\SiteMenu;
use App\Modules\SiteMenu\Widgets\FooterMenu;
use App\Modules\SiteMenu\Widgets\HeaderMenu;
use App\Modules\SiteMenu\Widgets\MobileMenu;
use CustomMenu, CustomSiteMenu, CustomRoles, Widget, Schema;
use App\Core\BaseProvider;
use Illuminate\Support\Collection;

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
        $this->setConfigNamespace('site_menu');
    }
    
    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        $places = config('site_menu.places');
        // Register left menu block
        $block = CustomMenu::get()->group()
            ->block('site_menu', 'site_menu::general.menu-block', 'fa fa-list');
        foreach ($places as $place) {
            $block->link("site_menu::general.$place", RouteObjectValue::make('admin.site_menu.index', ['place' => $place]))
                ->additionalRoutesForActiveDetect(
                    RouteObjectValue::make('admin.site_menu.edit', ['place' => $place]),
                    RouteObjectValue::make('admin.site_menu.create', ['place' => $place])
                );
        }
        // Register role scopes
        CustomRoles::add('site_menu', 'site_menu::general.menu')->except(RoleRule::VIEW);
    }
    
    protected function afterBoot()
    {
        if (Schema::hasTable('site_menu')) {
            $menu = new Collection();
            SiteMenu::activeOnly()->each(function (SiteMenu $siteMenu) use ($menu) {
                $elements = $menu->get((int)$siteMenu->parent_id, new Collection());
                $elements->push($siteMenu);
                $menu->put((int)$siteMenu->parent_id, $elements);
            });
            foreach ($menu->get(0, []) as $siteMenu) {
                $this->addMenuElement($siteMenu, $menu);
            }
        }
        Widget::register(FooterMenu::class, 'footer-menu');
        Widget::register(HeaderMenu::class, 'header-menu');
        Widget::register(MobileMenu::class, 'site-menu::mobile');
    }

    /**
     * @param SiteMenu $siteMenu
     * @param Collection|SiteMenu[] $menu
     * @param Link|null $link
     */
    private function addMenuElement(SiteMenu $siteMenu, Collection $menu, ?Link $link = null): void
    {
        if (!$siteMenu->current->slug || !$siteMenu->current->slug_type) {
            return;
        }
        $objectValue = new LinkObjectValue($siteMenu->current->slug, $siteMenu->current->slug_type);
        $objectValue->noIndex = $siteMenu->noindex;
        $objectValue->noFollow = $siteMenu->nofollow;
        if (!$link) {
            $link = CustomSiteMenu::get($siteMenu->place);
        }
        $link = $link->link(
            $siteMenu->current->name,
            $objectValue
        )
        ->setPosition($siteMenu->position);
        foreach ($menu->get($siteMenu->id, []) as $siteMenu) {
            $this->addMenuElement($siteMenu, $menu, $link);
        }
    }
    
}
