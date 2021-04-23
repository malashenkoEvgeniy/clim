@php
/** @var \App\Modules\Categories\Models\Category[] $categories */
@endphp
<ul class="nav-links{{ (isset($list_mod_classes) ? ' ' . $list_mod_classes : '') }}">
    @foreach($categories as $category)
        <li class="nav-links__item">
            <a class="nav-links__link" href="{{ $category->site_link }}">{{ $category->current->name }}</a>
        </li>
    @endforeach
</ul>
