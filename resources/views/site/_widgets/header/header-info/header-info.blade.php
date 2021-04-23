<div class="_ptb-sm _def-ptb-def">
    <div class="_flex _items-center _justify-center _def-justify-between">
        <div class="grid grid--1 grid--def-auto _items-center _flex-nowrap">
            <div class="gcell _pr-sm _sm-pr-def _def-show _hide-mobile">
                {!! Widget::show('logo') !!}
            </div>
{{--            <div class="gcell">--}}
{{--                @component('site._widgets.elements.slogan.slogan')--}}
{{--                    @slot('content'){!! config('db.basic.slogan') !!}@endslot--}}
{{--                @endcomponent--}}
{{--            </div>--}}
        </div>
        {!! Widget::show('contacts', 'header') !!}
        {!! Widget::show('products::search-bar') !!}
        {!! Widget::show('compare::action-bar') !!}
        {!! Widget::show('wishlist::action-bar') !!}
        {!! Widget::show('header-auth-link') !!}
        {!! Widget::show('orders::cart::splash-button') !!}

{{--        {!! Widget::show('categories::main-menu-children') !!}--}}
{{--        {!! Widget::show('contacts', 'header') !!}--}}
    </div>
</div>
