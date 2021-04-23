<div class="_pt-sm _ptb-def">
    <div class="_flex _flex-column _def-flex-row _items-center _justify-center _def-justify-between">
        <div class="grid grid--1 grid--def-auto _items-center _ms-flex-nowrap _mb-def _def-mb-none">
            <div class="gcell _pr-sm _sm-pr-def _text-center _ms-text-right _def-text-center">
                {!! Widget::show('logo') !!}
            </div>
            <div class="gcell _text-center _ms-text-left">
                @component('site._widgets.elements.slogan.slogan')
                    @slot('content'){!! config('db.basic.slogan') !!}@endslot
                @endcomponent
            </div>
        </div>
        <div class="_no-print">
            {!! Widget::show('contacts', 'header') !!}
        </div>
    </div>
</div>
