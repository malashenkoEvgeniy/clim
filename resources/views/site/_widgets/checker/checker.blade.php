<label class="checker{{ $disabled ?? null }}">
    <input class="checker__input" {!! Html::attributes($attributes ?? []) !!}>
    <i class="checker__icon">
        {!! SiteHelpers\SvgSpritemap::get($icon ?? 'icon-ok', [
            'class' => 'checker__symbol'
        ]) !!}
    </i>
    @if(isset($slot) && trim(strip_tags($slot)))
        <span class="checker__text">
            {{ $slot }}
        </span>
    @endif
</label>
