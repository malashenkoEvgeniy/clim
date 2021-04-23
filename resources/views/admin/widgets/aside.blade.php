@php
    /** @var \App\Components\Menu\Group[] $menu */
@endphp
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">

            @foreach($menu as $group)
                @if($group->canBeShowed())
                    @if($group->show())
                        <li class="header">{{ Lang::get($group->getName()) }}</li>
                    @endif
                    @foreach($group->getKids() as $element)
                        {!! Widget::show('aside-element', $element) !!}
                    @endforeach
                @endif
            @endforeach
        </ul>
    </section>
</aside>
