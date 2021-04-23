@php
/** @var int $index */
@endphp
<div class="box box-primary box-solid loaded modification" data-index="{{ $index }}">
    <div class="box-header with-border">
        <h3 class="box-title">@lang('products::admin.new-modification')</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-locotrade="delete">
                <i class="fa fa-trash"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-locotrade="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        {!! \App\Modules\Products\Forms\ProductForm::make(null, $index)->render() !!}
    </div>
</div>
