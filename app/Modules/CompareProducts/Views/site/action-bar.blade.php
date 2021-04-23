@php
/** @var int $total */
$isCurrent = preg_match('/^site.compare$/', Route::currentRouteName());
@endphp

<div class="action-bar__control _def-show">
    @if ($isCurrent || $total < 1)
        <a role="link" tabindex="0" data-href="{{ route('site.compare') }}"
            class="action-bar-control action-bar-control--compare  {{ $isCurrent ? 'is-current' : null }}"
            data-comparelist-link>
    @else
        <a href="{{ route('site.compare') }}"
            role="link" tabindex="0"
            class="action-bar-control action-bar-control--compare"
            data-comparelist-link>
    @endif
        {!! SiteHelpers\SvgSpritemap::get('icon-compare', ['class' => 'action-bar-control__icon']) !!}
        <div class="action-bar-control__title _ellipsis">@lang('compare::general.compare')</div>
        <div class="action-bar-control__count compare-count" data-comparelist-counter>{{ $total ?: null }}</div>
    </a>

    <div class="popover {{ $total > 0 ? '_hide' : null }}" data-comparelist-popover>
        <div class="grid _flex-nowrap">
            <div class="gcell gcell--auto _flex-noshrink _pr-def">
                {!! SiteHelpers\SvgSpritemap::get('icon-to-compare', [
                    'class' => 'svg-icon svg-icon--icon-to-compare',
                ]) !!}
            </div>
            <div class="gcell gcell--auto _flex-grow">
                <div class="title title--size-h3">@lang('compare::site.compare-products-empty')</div>
                <div>@lang('compare::site.add-products-to-compare')</div>
            </div>
        </div>
    </div>
</div>
