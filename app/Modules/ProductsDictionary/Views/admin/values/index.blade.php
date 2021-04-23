@php
/** @var \App\Modules\ProductsDictionary\Models\Dictionary[] $values */
$className = \App\Modules\ProductsDictionary\Models\Dictionary::class;
@endphp

@push('styles')
<style>
    .correct-button > a {
        border-radius: 3px!important;
        font-size: 13px;
        display: inline-block;
        height: 22px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ajaxComplete(function (event, jqxhr) {
        var response = prepareIncomingData(jqxhr.responseJSON);
        if (!response) {
            return false;
        }
        if (response.insert !== undefined) {
            $('#feature-values-list').html(response.insert);
        }
    });
</script>
@endpush

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('products_dictionary::admin.titleValues') }}</h3>
        <div class="box-tools pull-right">
            <button href="{{ route('admin.dictionary.create') }}" type="button" class="ajax-request btn btn-default">
                <i class="fa fa-plus-circle"></i> @lang('products_dictionary::admin.add-value')
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="col-xs-12">
            <div class="dd pageList" id="myNest" data-depth="1">
                <ol class="dd-list" id="feature-values-list">
                    @include('products_dictionary::admin.values.items', [
                        'values' => $values,
                    ])
                </ol>
            </div>
            <span id="parameters" data-url="{{ route('admin.dictionary.sortable', ['class' => $className]) }}"></span>
            <input type="hidden" id="myNestJson">
        </div>
    </div>
</div>

<div class="clearfix"></div>
