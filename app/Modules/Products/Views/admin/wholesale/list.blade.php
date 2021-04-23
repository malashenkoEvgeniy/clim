@php
/** @var \App\Modules\Products\Models\ProductWholesale[] $prices */
/** @var int $index */
$price = $quantity = [];
foreach ($prices as $wholesale) {
    $price[] = $wholesale->price;
    $quantity[] = $wholesale->quantity;
}
@endphp

<div class="form-group col-md-6 add-wholesale-block">
    <input name="modification[wholesaleQuantities][{{ $index }}]" value="{{ implode(';', $quantity) }}" class="wholesale-quantities" type="hidden" />
    <input name="modification[wholesalePrices][{{ $index }}]" value="{{ implode(';', $price) }}" class="wholesale-prices" type="hidden" />
    <label for="wholesale" style="margin-top: 10px; width: 100%; border-top: 1px solid #777;">@lang('products::admin.wholesale')</label>
    <table width="100%">
        <thead>
        <tr>
            <th>@lang('products::general.quantity')</th>
            <th>@lang('products::general.price')</th>
            <th style="text-align: center; width: 30px;">
                <button type="button" class="btn btn-flat btn-primary btn-xs add-wholesale" data-counter="">
                    <i class="fa fa-plus"></i>
                </button>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($prices as $price)
            <tr>
                <td>
                    <input class="form-control wholesale-quantity" min="2" type="number" value="{{ $price->quantity }}" />
                </td>
                <td>
                    <input class="form-control wholesale-price" type="text" value="{{ (float)$price->price }}" />
                </td>
                <td style="text-align: center; width: 30px;">
                    <button type="button" class="btn btn-flat btn-danger delete-row btn-xs">
                        <i class="fa fa-minus"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
