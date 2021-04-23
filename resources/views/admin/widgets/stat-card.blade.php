@php
    /** @var int $count */
    /** @var string $text */
    /** @var string $url */
    /** @var string $icon */
    /** @var string $color */
@endphp

<div class="col-lg-4 col-xs-6">
    <div class="small-box {{ $color }}">
        <div class="inner">
            <h3>{{ $count }}</h3>
            <p>{{ $text }}</p>
        </div>
        <div class="icon">
            <i class="ion {{ $icon }}"></i>
        </div>
        @if($url)
            <a href="{{ $url }}" class="small-box-footer">
                {{ __('global.more') }} <i class="fa fa-arrow-circle-right"></i>
            </a>
        @endif
    </div>
</div>
