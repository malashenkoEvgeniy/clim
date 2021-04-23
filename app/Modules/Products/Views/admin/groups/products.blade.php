@php
/** @var \App\Modules\Products\Models\ProductGroup $group */
$open = request()->query('open');
@endphp

@push('styles')
    <style>
        .modification.box-success button[data-locotrade="delete"],
        .modification.box-success button[data-locotrade="main"] {
            display: none;
        }
    </style>
@endpush

@push('scripts')
<script>
    const $featureSelect = $('#modifications').closest('form').find('[name="feature_id"]');
    $featureSelect.on('change', function () {
        if (!$featureSelect.val()) {
            $('#modifications').find('.feature-value-select').each(function () {
                $(this).html('');
                $(this).append(new Option('—', '', true, true));
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
                $('#modifications').find('.feature-value-select').each(function () {
                    $(this).html('');
                    for (const index in data.options) {
                        let option = data.options[index];
                        $(this).append(new Option(option.text, option.id, false, false));
                    }
                    $(this).val(null);
                });
            }
        });
    });

    @if(!$group || !$group->exists || !$group->feature_id)
        $.ajax({
            url: '{{ route('admin.feature-values.index') }}',
            type: 'POST',
            data: {
                feature: $featureSelect.val(),
            },
        }).done(function (data) {
            if (data.success) {
                var $valueSelect = $('#modifications').find('.modification:first-child select.feature-value-select');
                $valueSelect.html('');
                for (const index in data.options) {
                    let option = data.options[index];
                    $valueSelect.append(new Option(option.text, option.id, false, false));
                }
            }
        });
    @endif
    $('#add-modification').on('click', function () {
        var index = parseInt($('#modifications').find('.modification:last-child').data('index')) + 1;
        $.ajax({
            method: 'GET',
            url: '{{ route('admin.products.create') }}?index=' + index,
        }).done((data) => {
            const $mod = $(data.form);
            $('#modifications').append($mod);
            window.scrollTo(0, document.body.scrollHeight);
            const $valueSelect = $mod.find('.feature-value-select');
            if (!$featureSelect.val()) {
                $valueSelect.html('');
                $valueSelect.append(new Option('—', '', true, true));
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
                    $valueSelect.html('');
                    for (const index in data.options) {
                        let option = data.options[index];
                        $valueSelect.append(new Option(option.text, option.id, false, false));
                    }
                }
            });
        });
        return false;
    });
    $('body').on('click', '[data-locotrade="collapse"]', function () {
        const $button = $(this), $block = $button.closest('.modification'), $icon = $button.find('i.fa');
        if ($block.hasClass('loaded')) {
            if ($block.hasClass('collapsed-box')) {
                $block.removeClass('collapsed-box');
                $icon.addClass('fa-minus');
                $icon.removeClass('fa-plus');
            } else {
                $block.addClass('collapsed-box');
                $icon.addClass('fa-plus');
                $icon.removeClass('fa-minus');
            }
        } else {
            $.ajax({
                method: 'GET',
                url: $button.data('url'),
            }).done((data) => {
                const $form = $(data.form);
                $form.insertAfter($block);
                $block.remove();
            });
        }
        return false;
    });
    $('body').on('click', '[data-locotrade="delete"]', function () {
        const $button = $(this), $block = $button.closest('.modification');
        confirmation('Удалить модификацию?', () => {
            if ($block.hasClass('recently-created')) {
                $.ajax({
                    method: 'GET',
                    url: $button.data('url'),
                }).done((data) => {
                    if (data.success) {
                        $block.remove();
                    }
                });
            } else {
                $block.remove();
            }
        });
    });
    $('body').on('click', '[data-locotrade="main"]', function () {
        const $button = $(this), $block = $button.closest('.modification'), $icon = $button.find('i.fa');
        if ($block.hasClass('box-primary')) {
            $.ajax({
                method: 'GET',
                url: $button.data('url'),
            }).done((data) => {
                if (data.success) {
                    $('#modifications').find('.box-success').each(function () {
                        $(this).removeClass('box-success');
                        $(this).addClass('box-primary');
                    });
                    $block.removeClass('box-primary');
                    $block.addClass('box-success');
                }
            });
        }
    });
    $('body').on('click', '[data-locotrade="clone"]', function () {
        var index = parseInt($('#modifications').find('.modification:last-child').data('index')) + 1;
        const $button = $(this), $block = $button.closest('.modification');
        confirmation('Клонировать эту модификацию?', () => {
            $.ajax({
                method: 'POST',
                url: $button.data('url') + '?index=' + index,
            }).done((data) => {
                if (data.success) {
                    const $form = $(data.form);
                    $form.appendTo($('#modifications'));
                }
            });
        });
    });


    const updateQuantities = function($table) {
        const $tbody = $table.find('tbody');
        let quantities = [];
        $tbody.find('.wholesale-quantity').each(function () {
            quantities.push($(this).val());
        });
        $table.parent().find('.wholesale-quantities').val(quantities.join(';'));
    };
    const updatePrices = function($table) {
        const $tbody = $table.find('tbody');
        let prices = [];
        $tbody.find('.wholesale-price').each(function () {
            prices.push($(this).val());
        });
        $table.parent().find('.wholesale-prices').val(prices.join(';'));
    };

    $('body').on('click', '.add-wholesale-block .delete-row', function () {
        $(this).closest('tr').remove();
        updatePrices($(this).closest('.add-wholesale-block'));
    });
    $('body').on('click', '.add-wholesale', function () {
        const $block = $(this).closest('.add-wholesale-block');
        $block.find('tbody').append(`
            <tr>
                <td>
                    <input class="form-control wholesale-quantity" min="2" type="number" value="2" />
                </td>
                <td>
                    <input class="form-control wholesale-price" type="text" value="${$block.closest('.modification').find('.modification-price').val()}" />
                </td>
                <td style="text-align: center; width: 30px;">
                    <button type="button" class="btn btn-flat btn-danger delete-row btn-xs">
                        <i class="fa fa-minus"></i>
                    </button>
                </td>
            </tr>
        `);
        updateQuantities($(this).closest('.add-wholesale-block'));
        updatePrices($(this).closest('.add-wholesale-block'));
    });
    $('body').on('change', '.add-wholesale-block .wholesale-quantity', function () {
        updateQuantities($(this).closest('.add-wholesale-block'));
    });
    $('body').on('change', '.add-wholesale-block .wholesale-price', function () {
        updatePrices($(this).closest('.add-wholesale-block'));
    });
</script>
@endpush

<a class="btn btn-warning btn-flat" style="margin-bottom: 10px;" href="#" id="add-modification"><i class="fa fa-plus"></i> @lang('products::admin.add-modification')</a>

<div id="modifications">
    @if(!$group || !$group->products || $group->products->isEmpty())
        @include('products::admin.product.create', ['product' => null, 'index' => 0])
    @else
        @foreach($group->products as $product)
            @include('products::admin.product.update', [
                'product' => $product,
                'collapse' => $open ? ((int)$open !== $product->id) : !$loop->first,
                'index' => $loop->index,
            ])
        @endforeach
    @endif
</div>
