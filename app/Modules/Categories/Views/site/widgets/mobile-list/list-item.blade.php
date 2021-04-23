@php
/** @var \App\Modules\Categories\Models\Category $category */
@endphp

<li>
    <a href="{{ $category->site_link }}">
        @if($category->symbol)
            {!! \SiteHelpers\SvgSpritemap::get($category->symbol, [
                'class' => 'mm-custom-icon'
            ]) !!}
        @endif
        {{ $category->current->name }}
    </a>
    @php
    $kids = $category->getKids();
    @endphp
    @if($kids && $kids->isNotEmpty())
        <ul>
            @foreach($kids as $subCategory)
                @include('categories::site.widgets.mobile-list.list-item', ['category' => $subCategory])
            @endforeach
        </ul>
    @endif
</li>
