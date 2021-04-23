@php
/** @var \App\Modules\Products\Models\ProductGroup $group */
/** @var array $features */
/** @var array $values */
@endphp

@extends('admin.layouts.main')

@push('scripts')
    <script>
        const $featureSelect = $('#newFeatureId');
        $featureSelect.on('change', function () {
            if (!$featureSelect.val()) {
                $('#change-feature-form').find('select.value-select').each(function () {
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
                    $('#change-feature-form').find('select.value-select').each(function () {
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
        <h4>
            @lang('products::admin.change-main-feature-warning-title', [
                'feature' => $group->feature_id ? $group->feature->current->name : '-',
                'product' => $group->current->name,
            ])
        </h4>
        <p>@lang('products::admin.change-main-feature-warning-text')</p>
    </div>

    <div class="box">
        <div class="box-body">
            {!! Form::open(['method' => 'put', 'id' => 'change-feature-form']) !!}
            {!! \CustomForm\Select::create('feature_id')->setOptions(['id' => 'newFeatureId'])->add($features) !!}
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>@lang('products::admin.modification-name')</th>
                    <th>@lang('products::admin.new-value')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($group->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>
                            {!!
                                \CustomForm\Select::create('value[' . $product->id . ']')
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
