@php
/** @var \App\Modules\Products\Models\ProductGroup $group */
@endphp
<div style="vertical-align: top; text-align: left;">
    @if(($group->relevant_product && $group->relevant_product->preview) || $group->image)
        <span style="display: inline-block; width: 30px;">
            {!! Widget::show('image', $group->relevant_product ? $group->relevant_product->preview : $group->image, 'small', ['style' => 'max-width: 30px; max-height: 20px;']) !!}
        </span>
    @endif
    <span style="display: inline-block; width: calc(100% - 50px); margin-left: 10px;">
        @if($group->relevant_product)
            {{ $group->relevant_product->name }} - {{ $group->relevant_product->formatted_price_for_admin }}
        @else
            {{ $group->current->name }}
        @endif
    </span>
</div>
