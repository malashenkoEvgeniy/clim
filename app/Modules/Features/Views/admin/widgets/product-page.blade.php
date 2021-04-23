@php
/** @var array $featuresAndValues [featureId => [valueId, valueId,..],..] */
/** @var \CustomForm\Select $featuresSelect */
/** @var \CustomForm\Select $valuesSelect */
/** @var int|null $doNotShow */
@endphp

@push('scripts')
    <script>
        var $select = $('#feature-select'),
            $valuesSelect = $('#feature-value-select'),
            $createFeatureButton = $('#link-feature-create'),
            $createFeatureRoute = '{{ route('admin.features.show-modal') }}',
            $createValueRoute = '{{ route('admin.features.show-values-modal') }}';

        $select.on('change', function () {
            var $select = $(this);
            $valuesSelect.html('');
            if (!$select.val()) {
                $valuesSelect.append(new Option('—', '', true, true));
                $valuesSelect.prop('multiple', false);
                $valuesSelect.prop('disabled', true);
                $valuesSelect.select2("destroy");
                $valuesSelect.select2();
                $createFeatureButton.show();
                $createFeatureButton.text('@lang('features::general.create-feature')');
                $createFeatureButton.attr('href', $createFeatureRoute);
                return false;
            }
            $.ajax({
                url: '{{ route('admin.feature-values.index') }}',
                type: 'POST',
                data: {
                    feature: $select.val(),
                },
            }).done(function (data) {
                $valuesSelect.val(null).trigger('change');
                $createFeatureButton.text('@lang('features::general.add-value')');
                $createFeatureButton.attr('href', $createValueRoute + '/' + $select.val());
                if (data.success) {
                    for (var index in data.options) {
                        var option = data.options[index];
                        $valuesSelect.append(new Option(option.text, option.id, false, false));
                    }
                    $valuesSelect.prop('disabled', false);
                    $valuesSelect.prop('multiple', true);
                    if (data.multiple) {
                    } else {
                        $valuesSelect.prop('multiple', false);
                    }
                    $valuesSelect.select2("destroy");
                    $valuesSelect.val(null);
                    $valuesSelect.select2();
                }
            });
        });

        $('#link-feature-value').on('click', function () {
            var featureId = $('#feature-select').val(),
                featureValueId = $('#feature-value-select').val();
            $.ajax({
                type: 'POST',
                data: {
                    feature_id: featureId,
                    value_id: featureValueId,
                },
            }).done(function (data) {
                if (data.insert !== undefined) {
                    $('#linked-features').html(data.insert);
                }
                $select.val(null).trigger('change');
            });
        });
    </script>
@endpush

{!! $featuresSelect->render() !!}
{!! $valuesSelect->render() !!}
<div class="form-group col-md-1" style="padding-top: 25px;">
    <button class="btn btn-default" type="button" id="link-feature-value">@lang('features::general.add')</button>
</div>
<div class="form-group col-md-2" style="padding-top: 25px">
    <button href="{{ route('admin.features.show-modal') }}" class="ajax-request btn btn-default" id="link-feature-create">@lang('features::general.create-feature')</button>
</div>
<div id="linked-features" class="col-md-12">
    {!! Widget::show('features::admin::product-page', $featuresAndValues, $doNotShow) !!}
</div>
