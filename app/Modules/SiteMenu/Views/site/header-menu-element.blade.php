@php
/** @var \App\Components\SiteMenu\Link $element */
@endphp
<div class="header-line-item {{ $element->hasKids() ? 'has-submenu' : '' }}">
    @if($element->getLink()->noIndex)
        <noindex>
    @endif
        <a class="header-line-item__link" href="{{ $element->getUrl() }}"{!! $element->getLink()->noFollow() !!}>
            {{ $element->name }}
        </a>
    @if($element->getLink()->noIndex)
        </noindex>
    @endif
    @if($element->hasKids())
        <div class="header-line-submenu">
            <div class="header-line-submenu__inner">
                @foreach($element->getKids() as $link)
                    <div class="header-line-submenu__item">
                        @if($element->getLink()->noIndex)
                            <noindex>
                        @endif
                        <a href="{{ $link->getUrl() }}" class="header-line-submenu__link"{!! $link->getLink()->noFollow() !!}>
                            {{ $link->name }}
                        </a>
                        @if($element->getLink()->noIndex)
                            </noindex>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>