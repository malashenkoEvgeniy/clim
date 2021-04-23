@php
/** @var \App\Components\SiteMenu\Group $menu */
@endphp

<div class="side-links">
    @foreach($menu->getKids() as $link)
        <div>
            {!! Html::link($link->isActive() ? null : $link->getUrl(), __($link->name), [
                'class' => ['side-link', $link->isActive() ? 'is-active' : null],
            ]) !!}
        </div>
    @endforeach
</div>
