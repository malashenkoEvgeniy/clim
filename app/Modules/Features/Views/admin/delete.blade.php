@php
/** @var \App\Modules\Features\Models\Feature $feature */
/** @var \App\Modules\Features\Models\FeatureValue[] $usedValues */
/** @var array $features */
/** @var array $values */
/** @var int $countOfProductsWithThisFeature */
@endphp

@extends('admin.layouts.main')

@push('scripts')
    <script>
        const $featureSelect = $('#newFeatureId');
        $featureSelect.on('change', function () {
            if (!$featureSelect.val()) {
                $('#change-features-and-values-form').find('select.value-select').each(function () {
                    $(this).html('');
                });
                return false;
            }
            $.ajax({
                url: '{{ route('admin.feature-values.index') }}',
                type: 'POST',
                data: {
                    feature: $featureSelect.val(),
                },
            }).done(function (data) {
                if (data.success) {
                    $('#change-features-and-values-form').find('select.value-select').each(function () {
                        $(this).html('');
                        for (const index in data.options) {
                            let option = data.options[index];
                            $(this).append(new Option(option.text, option.id, false, false));
                        }
                    });
                }
            });
        });
    </script>
@endpush

@section('content-no-row')
    <div class="callout callout-danger">
        <h4>@lang('features::messages.destroy-feature-warning-title', ['feature' => $feature->current->name, 'count' => $countOfProductsWithThisFeature])</h4>
        <p>@lang('features::messages.destroy-feature-warning-text')</p>
    </div>

    <div class="box">
        <div class="box-body">
            {!! Form::open(['method' => 'delete', 'id' => 'change-features-and-values-form']) !!}
            {!! \CustomForm\SimpleSelect::create('feature_id')->setLabel('features::general.feature')->setOptions(['id' => 'newFeatureId'])->add($features) !!}
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>@lang('features::admin.current-value')</th>
                    <th>@lang('features::admin.choose-new-value')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($usedValues as $value)
                    <tr>
                        <td>{{ $value->current->name }}</td>
                        <td>
                            {!!
                                \CustomForm\SimpleSelect::create('value[' . $value->id . ']')
                                    ->addClasses('value-select')
                                    ->add($values)
                                    ->setLabel(false)
                            !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <button class="btn btn-flat" type="submit">@lang('buttons.save')</button>
            {!! Form::close() !!}
        </div>
    </div>
@stop
