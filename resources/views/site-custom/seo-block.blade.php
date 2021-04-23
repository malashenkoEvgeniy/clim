@php
/** @var string $h1 */
/** @var string $text */
@endphp

@component('site._widgets.wysiwyg.seo-text')
    {{--@slot('h1')
        {{ $h1 }}
    @endslot--}}
    {!! $text !!}
@endcomponent