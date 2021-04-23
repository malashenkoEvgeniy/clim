<label class="radio {{ $classes ?? null }}" {!! $rootAttrs ?? null !!}>
    <input class="radio__input" {!! Html::attributes($attributes ?? []) !!}>
    <i class="radio__icon"></i>
    <span class="radio__text">{{ $slot }}</span>
</label>
