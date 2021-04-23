@php
/** @var \App\Components\SiteMenu\Group $menu */
@endphp

@foreach($menu->getKids() as $element)
    <li>
    @if($element->getLink()->noIndex)
        <!--noindex-->
        @endif
        <a href="{{ $element->getUrl() }}" {!! $element->getLink()->noFollow() !!}>
            @if($element->icon)
                {!! \SiteHelpers\SvgSpritemap::get($element->icon, [
                    'class' => 'mm-custom-icon'
                ]) !!}
            @endif
            {{ $element->name }}
        </a>
        @if($element->getLink()->noIndex)
        <!--/noindex-->
        @endif
        @if($element->hasKids())
            <ul>
                @foreach($element->getKids() as $link)
                    <li>
                    @if($element->getLink()->noIndex)
                        <!--noindex-->
                        @endif
                        <a href="{{ $link->getUrl() }}" {!! $link->getLink()->noFollow() !!}>
                            @if($link->icon)
                                {!! \SiteHelpers\SvgSpritemap::get($link->icon, [
                                    'class' => 'mm-custom-icon'
                                ]) !!}
                            @endif
                            {{ $link->name }}
                        </a>
                        @if($element->getLink()->noIndex)
                        <!--/noindex-->
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
@endforeach