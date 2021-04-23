@php
/** @var int $total */
@endphp

<div class="gcell _xs-ml-xs">
    <a href="{{ route('site.compare') }}" tabindex="0" class="menu-button" title="@lang('compare::site.compare')">
        {!! \SiteHelpers\SvgSpritemap::get('icon-compare', ['class' => 'menu-button__icon']) !!}
        <div class="menu-button__count" data-comparelist-counter>{{ $total ?: null }}</div>
    </a>
</div>
