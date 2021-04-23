@php
/** @var \App\Components\SiteMenu\Group $menu */
@endphp

<ul id="user-account">
    @foreach($menu->getKids() as $link)
        <li>
            <a href="{{ $link->getUrl() }}">
                {!! SiteHelpers\SvgSpritemap::get($link->icon, [
                    'class' => 'mm-custom-icon'
                ]) !!}
                {{ __($link->name) }}
            </a>
        </li>
    @endforeach
    <li>
        <a href="{{ route('site.logout') }}">
            {!! SiteHelpers\SvgSpritemap::get('icon-logout', [
                'class' => 'mm-custom-icon'
            ]) !!}
            @lang('users::site.logout-from-the-site')
        </a>
    </li>
</ul>
