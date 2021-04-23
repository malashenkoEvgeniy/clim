@php
/** @var \App\Components\SiteMenu\Group $menu */
@endphp
<ul class="nav-links{{ (isset($list_mod_classes) ? ' ' . $list_mod_classes : '') }}">
    @foreach($menu->getKids() as $link)
        <li class="nav-links__item">
            <a class="nav-links__link" href="{{ $link->getUrl() }}">{{ $link->name }}</a>
        </li>
    @endforeach
</ul>
