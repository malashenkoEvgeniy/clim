@php
/** @var int $total */
$isCurrent = preg_match('/^site.wishlist$/', Route::currentRouteName());
@endphp
<div class="action-bar__control _def-show">
        @if ($isCurrent || $total < 1)
            <a role="link" tabindex="0" data-href="{{ route('site.wishlist') }}"
                class="action-bar-control action-bar-control--wishlist  {{ $isCurrent ? 'is-current' : null }}"
            data-wishlist-link>
        @else
            <a href="{{ route('site.wishlist') }}"
                role="link" tabindex="0"
                class="action-bar-control action-bar-control--wishlist"
            data-wishlist-link>
        @endif
        {!! SiteHelpers\SvgSpritemap::get('icon-wishlist', ['class' => 'action-bar-control__icon']) !!}
        <div class="action-bar-control__title _ellipsis">@lang('wishlist::site.action-bar-button')</div>
        <div class="action-bar-control__count" data-wishlist-counter>{{ $total ?: null }}</div>
    </a>
    <div class="popover {{ $total > 0 ? '_hide' : null }}" data-wishlist-popover>
        <div class="grid _flex-nowrap">
            <div class="gcell gcell--auto _flex-noshrink _pr-def">
                {!! SiteHelpers\SvgSpritemap::get('icon-wishlist', [
					'class' => 'svg-icon svg-icon--icon-wishlist',
				]) !!}
            </div>
            <div class="gcell gcell--auto _flex-grow">
                <div class="title title--size-h3">Список желаний пуст</div>
                @if(Auth::check())
                    <div>Добавляйте товары в список желаний.</div>
                @else
                    <div>Добавляйте товары в список желаний. Если у вас уже есть список желаний, <span role="button" class="js-init" data-mfp="inline" data-mfp-src="#popup-regauth">авторизуйтесь</span></div>
                @endif
            </div>
        </div>
    </div>
</div>
