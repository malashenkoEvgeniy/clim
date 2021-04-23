@php
$_is_open = isset($open) && $open;
@endphp

<div class="accordion-header{{ $_is_open ? ' is-open is-active' : null }}"
        role="button"
        tabindex="0"
        data-wstabs-ns="{{ $ns }}"
        data-wstabs-button="{{ $id }}">
    <div class="accordion-header__name">
        {{ $header }}
    </div>
    <div class="accordion-header__caret">
        {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-bottom-thin', [
            'class' => 'accordion-header__icon'
        ]) !!}
    </div>
</div>

<div class="accordion-body{{ $_is_open ? null : ' is-open is-active' }}"
        style="{{ $_is_open ? null : 'display: none' }}"
        data-wstabs-ns="{{ $ns }}"
        data-wstabs-block="{{ $id }}">
    {{ $slot }}
</div>
