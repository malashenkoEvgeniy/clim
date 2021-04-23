@php
/** @var \App\Modules\Products\Models\Product $product */
/** @var bool $collapse */
/** @var int $index */
$collapse = $collapse ?? false;
@endphp
<div class="box box-{{ $product->is_main ? 'success' : 'primary' }} box-solid {{ $collapse ? 'collapsed-box' : 'loaded' }} modification recently-created" data-index="{{ $index }}">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $product->name . ' - ' . $product->formatted_price_for_admin }}</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-locotrade="clone" data-url="{{ route('admin.products.clone', $product->id) }}">
                <i class="fa fa-clone"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-locotrade="delete" data-url="{{ route('admin.products.destroy', $product->id) }}">
                <i class="fa fa-trash"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-locotrade="main" data-url="{{ route('admin.products.main', $product->id) }}">
                <i class="fa fa-toggle-off"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-locotrade="collapse" data-url="{{ route('admin.products.edit', [$product->id, 'index' => $index]) }}">
                <i class="fa fa-{{ $collapse ? 'plus' : 'minus' }}"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        @if(!$collapse)
            {!! \App\Modules\Products\Forms\ProductForm::make($product, $index)->render() !!}
        @endif
    </div>
</div>
