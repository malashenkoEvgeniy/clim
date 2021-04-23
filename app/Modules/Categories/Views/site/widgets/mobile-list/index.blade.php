<li>
    <a href="{{ route('site.categories') }}" class="mm-custom-link">
        @lang('categories::site.catalog')
    </a>
    <ul>
        @foreach(\App\Modules\Categories\Models\Category::getKidsFor(0) as $category)
            @include('categories::site.widgets.mobile-list.list-item', ['category' => $category])
        @endforeach
    </ul>
</li>
