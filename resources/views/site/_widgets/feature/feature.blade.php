<div class="feature {{ $mod_class ?? '' }}">
    <div class="feature__icon">
        {!! SiteHelpers\SvgSpritemap::get($icon) !!}
    </div>
    <div class="feature__name">{{ $name }}</div>
    <div class="feature__desc">{{ $desc }}</div>
</div>
