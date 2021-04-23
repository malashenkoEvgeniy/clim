@php
/** @var string $url */
/** @var string $title */
/** @var bool $active */
/** @var string $classes */
@endphp

<a href="{{ $url }}" class="{{ $classes }} {{ $active ? 'disabled-opacity' : null }}">{{ $title }}</a>
