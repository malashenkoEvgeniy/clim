@php
/** @var \App\Core\Modules\Images\Models\Image $image */
@endphp
<a href="{{ $link }}" class="item-card-preview">
    {!! $image->imageTag('small', ['class' => 'item-card-preview__image', 'alt' => "$product->name", 'title' => "$product->name"]) !!}
</a>
