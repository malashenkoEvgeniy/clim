<a href="{{ $href }}" class="goto goto--{{ $to }} {{ $mod_class ?? '' }}">
    <span>{{ $text }}</span>
    <span class="goto__icon">
        {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-' . ($to === 'prev' ? 'left' : 'right') .  '-thin') !!}
    </span>
</a>
