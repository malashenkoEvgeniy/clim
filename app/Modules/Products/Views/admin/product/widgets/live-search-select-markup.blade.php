@php
/** @var \App\Modules\Products\Models\Product $product */
@endphp

<strong>[{{ $product->id }}]</strong> {{  $product->name }} - {{  $product->formatted_price }}
