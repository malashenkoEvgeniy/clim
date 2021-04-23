@php
/** @var \App\Modules\Features\Models\Feature[] $feature */
/** @var \App\Modules\Features\Models\FeatureValue[] $values */
$className = \App\Modules\Features\Models\FeatureValue::class;
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
        <h3 class="box-title">{{ __('features::general.titleValues') }}</h3>
        <div class="box-tools pull-right">
            <button href="{{ route('admin.feature-values.create', $feature->id) }}" type="button" class="ajax-request btn btn-default">
                <i class="fa fa-plus-circle"></i> @lang('features::general.add-feature-value')
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="col-xs-12">
            <div class="dd pageList" id="myNest" data-depth="1">
                <ol class="dd-list" id="feature-values-list">
                    @include('features::admin.values.items', [
                        'values' => $values,
                        'feature' => $feature,
                    ])
                </ol>
            </div>
            <span id="parameters" data-url="{{ route('admin.feature-values.sortable', ['class' => $className]) }}"></span>
            <input type="hidden" id="myNestJson">
        </div>
    </div>
</div>

<div class="clearfix"></div>
