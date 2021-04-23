<?php
/** @var \App\Components\Menu\Link $element */
/** @var string[] $classes */
?>

<li class="{!! implode(' ', $classes) !!}">
    <a href="{{ $element->getUrl() }}">
        @if($element->icon)
            <i class="{{ $element->icon }}"></i>
        @endif
        <span>{{ Lang::get($element->name) }}</span>
        @if($element->hasCounter())
            <span class="pull-right-container">
                <small class="label pull-right {{ $element->getCounterColor() }}">{{ $element->getCounter() }}</small>
            </span>
        @endif
    </a>
</li>
