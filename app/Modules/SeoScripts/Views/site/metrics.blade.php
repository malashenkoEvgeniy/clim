@php
    /** @var \App\Modules\SeoScripts\Models\SeoScript[] $items */
@endphp

@foreach($items as $item)
    @if(!empty($item->script))
        {!! $item->script !!}
    @endif
@endforeach
