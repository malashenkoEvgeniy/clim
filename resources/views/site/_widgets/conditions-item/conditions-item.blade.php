@php
/** @var bool $isOpen */
$isOpen = $isOpen ?? false;
@endphp

<div class="conditions-item">
    <div class="conditions-item__head {{ $isOpen ? 'is-open' : null }}" data-wstabs-ns="conditions" data-wstabs-button="{{ $tabs }}">
        <div class="grid _flex-nowrap _items-center">
            @if($icon)
            <div class="gcell _flex-noshrink">
                <div class="conditions-item__icon">
                    {!! SiteHelpers\SvgSpritemap::get($icon) !!}
                </div>
            </div>
            @endif
            <div class="gcell _pl-sm">
                <div class="conditions-item__title">{{ $title }}</div>
            </div>
        </div>
    </div>
    <div {!! $isOpen ? 'class="is-open"' : 'style="display: none;"' !!} data-wstabs-ns="conditions" data-wstabs-block="{{ $tabs }}">
        <div class="conditions-item__descr">
            {!! $descr !!}
        </div>
        <div class="conditions-item__link js-init" data-mfp="ajax" data-mfp-src="{{ $url }}">
            @lang('buttons.detail')
        </div>
    </div>
</div>
