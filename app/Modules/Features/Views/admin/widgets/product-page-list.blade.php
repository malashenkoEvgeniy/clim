@php
/** @var \App\Modules\Features\Models\Feature[] $features */
/** @var array $featuresAndValues [featureId => [valueId, valueId,..],..] */
/** @var int|null $doNotShow */
@endphp

@if(request()->expectsJson())
    <script>
        $('#linked-features').find('.select2').select2();
    </script>
@endif

@push('scripts')
    <script>
        $('#linked-features').on('click', 'button.remove-feature', function () {
            var $button = $(this), $tr = $button.closest('tr');
            confirmation($button.data('confirmation'), function () {
                $.ajax({
                    url: $button.attr('href'),
                    type: 'POST',
                    data: {
                        feature_id: $button.data('feature'),
                        type: 'destroy',
                    },
                }).done(function (data) {
                    if (data.success) {
                        $tr.remove();
                    }
                });
            });
        });

        $('#linked-features').on('click', 'button.update-feature', function () {
            var $button = $(this), $tr = $button.closest('tr');
            $.ajax({
                url: $button.attr('href'),
                type: 'POST',
                data: {
                    feature_id: $button.data('feature'),
                    values_ids: $tr.find('td.feature-values-place select').val(),
                    type: 'update',
                },
            });
        });
    </script>
@endpush

<table class="table table-striped">
    @foreach($features as $feature)
        @if($doNotShow === $feature->id)
            @continue
        @endif
        <tr>
            <td style="width: 20%;" class="feature-place">
                {!! Html::link(
                    $feature->link_in_admin_panel,
                    $feature->current->name,
                    ['target' => '_blank']
                ) !!}
            </td>
            <td style="width: calc(80% - 100px);" class="feature-values-place">
                @php
                    $model = new \App\Components\Form\ObjectValues\ModelForSelect($feature->values);
                    $model->setValueFieldName('current.name');
                @endphp
                @if($feature->type === \App\Modules\Features\Models\Feature::TYPE_MULTIPLE)
                    {!!
                        \CustomForm\Macro\MultiSelect::create('feature-' . $feature->id)
                            ->setValue(array_get($featuresAndValues, $feature->id, []))
                            ->model($model)
                            ->setLabel(false)
                    !!}
                @else
                    {!!
                        \CustomForm\SimpleSelect::create('feature-' . $feature->id)
                            ->setValue(array_get($featuresAndValues, $feature->id, []))
                            ->model($model)
                            ->setLabel(false)
                    !!}
                @endif
            </td>
            <td style="width: 100px;">
                <button
                    type="button"
                    class="btn btn-flat update-feature"
                    href="{{ URL::current() }}"
                    data-feature="{{ $feature->id }}"
                >
                    <i class="fa fa-save"></i>
                </button>
                <button
                    type="button"
                    class="btn btn-flat btn-danger remove-feature"
                    data-confirmation="@lang('features::general.delete-feature-link')"
                    href="{{ URL::current() }}"
                    data-feature="{{ $feature->id }}"
                >
                    <i class="fa fa-trash-o"></i>
                </button>
            </td>
        </tr>
    @endforeach
</table>
