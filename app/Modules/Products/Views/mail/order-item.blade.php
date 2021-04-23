@php
/** @var \App\Modules\Products\Models\Product $product */
@endphp

@if($product)
    <tr>
        <td rowspan="2" width="20%" style="min-width: 50px;">
            <a href="{{ $product->site_link }}" style="display: block; padding: 0 15px 0 0">
                {!! Widget::show('image', $product->preview, 'small', ['style' => 'width: 100%; max-width: 80px;']) !!}
            </a>
        </td>
        <td colspan="2" style="vertical-align: top;">
            <a href="{{ $product->site_link }}" class="product-name">
                {{ $product->name }}
            </a>
        </td>
    </tr>
@else
    <tr>
        <td colspan="2" style="vertical-align: top;">
            @lang('products::site.deleted')
        </td>
    </tr>
@endif
