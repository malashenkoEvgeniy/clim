<div class="action-bar__side _def-show">
    @include('categories::site.widgets.left-sidebar.action-bar-catalog', [
        'expanded' => Route::currentRouteName() === 'site.home',
        'categories' => \App\Modules\Categories\Models\Category::getKidsFor(0),
    ])
</div>
