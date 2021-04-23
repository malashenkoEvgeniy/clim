@php
    /** @var \App\Modules\Products\Models\ProductGroup[] $relatedGroups */
    /** @var \App\Modules\Products\Models\ProductGroup $group */
@endphp

@push('styles')
    <style>
        .correct-button > a {
            border-radius: 3px !important;
            font-size: 13px;
            display: inline-block;
            height: 22px;
        }

        .related-list li {
            list-style: none;
            padding: 0;
        }

        .mailbox-attachments li:first-child {
            display: block;
            float: none;
            width: 100%;
            border: 0 solid #eee;
            margin-bottom: 10px;
            margin-right: 0;
        }
    </style>
@endpush
@push('scripts')
    <script>
        function updateIgnoredList(productId, remove) {
            if (!productId) {
                return;
            }
            productId = parseInt(productId);
            remove = remove || false;
            let $select2 = $('#related-products-list').find('select.js-data-ajax'),
                ignored = $select2.data('ignored') || [],
                isInArray = $.inArray(productId, ignored) !== -1;

            if (remove === true && isInArray) {
                ignored.push(productId);
                ignored = $.grep(ignored, function (value) {
                    return value !== productId;
                });
            } else if (remove !== true && isInArray === false) {
                ignored.push(productId);
            }

            $select2.data('ignored', ignored);
        }

        $('#add-related').on('click', function (e) {
            e.preventDefault();
            let $li = $(this).closest('li'),
                $select = $li.find('select'),
                url = $li.data('href'),
                related = $select.val();
            $select.val(null).trigger('change');
            $.ajax({
                url,
                method: 'POST',
                dataType: 'json',
                data: {
                    groupId: related,
                }
            }).then(function (data) {
                if (data.success) {
                    $li.closest('ul').append(data.element);
                }
                updateIgnoredList(related, false);
            });
        });
        $('#related-products').on('click', '.remove-by-ajax', function (e) {
            e.preventDefault();
            let $a = $(this);
            confirmation('@lang('products::admin.delete-related-product-message')', () => {
                $.ajax({
                    url: $a.attr('href'),
                    method: 'GET'
                }).done(function () {
                    updateIgnoredList($a.closest('li').data('id'), true);
                    $a.closest('li').remove();
                });
            });
        });
    </script>
@endpush

<div class="box box-info" id="related-products">
    <div class="box-header with-border">
        <h3 class="box-title">@lang('products::general.attributes.related')</h3>
    </div>
    <div class="box-body">
        <ul class="mailbox-attachments clearfix" id="related-products-list">
            <li data-href="{{ route('admin.groups.add-related', $group->id) }}">
                <span style="width: 88%; display: inline-block;">
                    {!! Widget::show('products::groups::live-search', $group->ignored_for_live_search) !!}
                </span>
                <button style="width: 10%; display: inline-block;" id="add-related" class="btn btn-primary btn-flat">
                    <i class="fa fa-plus"></i>
                </button>
            </li>
            @foreach($relatedGroups as $item)
                @include('products::admin.related.item', ['group' => $group, 'item' => $item])
            @endforeach
        </ul>
    </div>
</div>
