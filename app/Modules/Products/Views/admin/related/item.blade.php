@php
/** @var \App\Modules\Products\Models\ProductGroup $group */
/** @var \App\Modules\Products\Models\Product $item */
$deleteUrl = route('admin.groups.remove-related', [
    'group' => $group->id,
    'item' => $item->id,
])
@endphp
<li data-id="{{ $item->id }}">
    <span class="mailbox-attachment-icon has-img">
        @if($item->preview && $item->preview->exists)
            <img src="{{ $item->preview->link('small') }}" alt="{{ $item->preview->current->alt }}">
        @else
            <i class="glyphicon glyphicon-ban-circle"></i>
        @endif
    </span>
    <div class="mailbox-attachment-info">
        <a href="{{ route('admin.groups.edit', $item->id) }}" class="mailbox-attachment-name" target="_blank">
            @if($item->relevant_product)
                {{ $item->relevant_product->name }} - {{ $item->relevant_product->formatted_price_for_admin }}
            @else
                {{ $item->current->name }}
            @endif
        </a>
        <div class="mailbox-attachment-size">
            {{ $item->vendor_code }}
        </div>
        <div style="text-align: right;">
            <span href="{{ $deleteUrl }}" class="btn btn-danger btn-xs remove-by-ajax" data-toggle="confirmation">
                <i class="fa fa-close"></i>
            </span>
        </div>
    </div>
</li>
