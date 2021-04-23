@if(browserizr()->isDesktop())
    <div class="fixed-menu">
        {!! Widget::show('social_buttons::icons') !!}
        <div class="fixed-menu__item fixed-menu__item--gap">
            {!! Widget::show('consultation-button') !!}
        </div>
        @include('site._widgets.elements.up-button.up-button')
    </div>
@endif
