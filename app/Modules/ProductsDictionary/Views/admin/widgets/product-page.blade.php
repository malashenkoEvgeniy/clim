@php
/** @var \CustomForm\Select $dictionarySelect */
@endphp

@push('scripts')
    <script>

        $(document).on('click', 'button.update-dictionary', function () {
            var $button = $(this),
                $box = $button.closest('.box-body');
            $.ajax({
                url: $button.attr('href'),
                type: 'POST',
                data: {
                    group_id: $button.data('group'),
                    values_ids: $box.find('select').val(),
                    type: 'update',
                },
            });
        });
    </script>
@endpush

{!! $dictionarySelect->render() !!}
<div class="form-group col-md-2" style="padding-top: 25px;">
    <button
        type="button"
        class="btn btn-flat update-dictionary"
        href="{{ route('admin.dictionary.update-relations') }}"
        data-group="{{ $groupId }}"
    >
        <i class="fa fa-save"></i>
    </button>
</div>
