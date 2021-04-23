<div class="gcell gcell--def-6 _pl-def _lg-pl-lg">
    <div class="title title--size-h4">@lang('categories::site.catalog')</div>
    <div class="_mtb-def">
        @include('categories::site.widgets.footer-menu.nav-links.nav-links', [
            'categories' => \App\Modules\Categories\Models\Category::getKidsFor(0),
            'list_mod_classes' => '_def-columns-md-2'
        ])
    </div>
</div>
