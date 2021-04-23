@php
    /** @var \App\Modules\Orders\Models\Order $order */
    $canEdit = CustomRoles::can('orders.edit');

    $siteStatusTitle = config('db.products_dictionary.'. Lang::getLocale() .'_title', null);
    $siteStatus = config('db.products_dictionary.site_status');
@endphp

@push('scripts')
    <script>
        $('body').on('click', '.delete-row', function () {
            $(this).closest('tr').remove();
        });
        $('body').find('.js-data-ajax').on('select2:select', function (e) {
            var product = e.params.data, $form = $('#add-item-block');
            console.log(product);
            $form.find('[name="product-price"]').val(product.price);
            $form.find('[name="product-name"]').val(product.name);
            $form.find('[name="product-formatted-price"]').val(product.formatted_price);
            $form.find('[name="dictionary"]').val(product.dictionary_id);
        });
        $('#add-item-block').on('click', '.add-row', function () {
            var $block = $('#add-item-block'),
                productName = $block.find('[name="product-name"]').val(),
                productId = $block.find('[name="product_id"]').val(),
                productFormattedPrice = $block.find('[name="product-formatted-price"]').val(),
                productPrice = $block.find('[name="product-price"]').val(),
                dictionary = $block.find('[name="dictionary"]').val(),
                dictionarySelect = '',
                productQuantity = parseInt($block.find('[name="product-quantity"]').val());

            if (!productId || !productPrice || !productQuantity) {
                message('Выберите товар и его количество!', 'error');
                return false;
            }

            if(dictionary){
                dictionarySelect = `<td>${JSON.parse(dictionary)}</td>`;
            }
            $('#add-item-block').find('.js-data-ajax').val(null).trigger('change');
            $('#add-item-block').find('[name="product-quantity"]').val(1);

            var addRow = true;
            $('#added-items-list').find('tr').each(function () {
                var $tr = $(this), id = $tr.data('id');
                if (id == productId && !dictionarySelect.length) {
                    $tr.find('.quantity-place').val(parseInt($tr.find('.quantity-place').val()) + productQuantity);
                    addRow = false;
                }
            });
            if (addRow === false) {
                return false;
            }
            $('#added-items-list').prepend(`
            <tr data-id="${productId}">
                <td>
                    <input type="hidden" name="items[new][${productId}][price]" value="${productPrice}">
                    ${productName}
                </td>
                <td>${productFormattedPrice}</td>
                ${dictionarySelect}
                <td width="100px">
                    <input type="number" class="form-control quantity-place" name="items[new][${productId}][quantity][]" value="${productQuantity}" min="1">
                </td>
                <td>
                    <button type="button" class="btn btn-flat btn-danger delete-row">
                        <i class="fa fa-minus"></i>
                    </button>
                </td>
            </tr>
            `);
        });
    </script>
@endpush

<div class="col-md-12">
    <div class="box box-default">
        <div class="box-body">
            <div id="add-item-block">
                {!! \CustomForm\Hidden::create('product-formatted-price') !!}
                {!! \CustomForm\Hidden::create('product-name') !!}
                {!! \CustomForm\Hidden::create('product-price')->setDefaultValue(0) !!}
                {!! \CustomForm\Hidden::create('dictionary')->setDefaultValue(0) !!}
                <div class="form-group col-md-7">
                    <label class="form-label">@lang('orders::general.choose-product')</label>
                    {!!
                        \CustomForm\Text::create('product')
                            ->setDefaultValue(Widget::show('products::groups::live-search', [], 'product_id', null, ['data-type' => 'product']))
                    !!}
                </div>
                <div class="form-group col-md-4">
                    {!!
                        \CustomForm\Input::create('product-quantity')
                            ->setType('number')
                            ->setLabel('orders::general.quantity')
                            ->setDefaultValue(1)
                            ->setOptions(['min' => 1])
                    !!}
                </div>
                <div class="form-group col-md-1" style="padding-top: 25px;">
                    <button type="button" class="btn btn-flat btn-primary add-row">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>@lang('orders::general.choose-product')</td>
                    <td>@lang('orders::general.price-for-one')</td>
                    @if($siteStatus)
                        <td>{{ $siteStatusTitle }}</td>
                    @endif
                    <td>@lang('orders::general.quantity')</td>
                    <td></td>
                </tr>
                </thead>
                <tbody id="added-items-list">
                @foreach($order->items as $item)
                    <tr data-id="{{ $item->product_id }}">
                        <td>
                            <input type="hidden" name="items[price][{{ $item->product_id }}]"
                                   value="{{ $item->price }}">
                            {!! Widget::show('products::in-invoice', $item->product_id) !!}
                        </td>
                        <td>{{ $item->formatted_price }}</td>
                        @if($siteStatus)
                            <td>{!! Widget::show('products_dictionary::choose-in-order', $item) !!}</td>
                        @endif
                        <td width="100px">
                            <input type="number" class="form-control quantity-place"
                                   name="items[quantity][{{ $item->product_id }}][{{ $item->id }}]"
                                   value="{{ $item->quantity }}" min="1">
                        </td>
                        <td>
                            <button type="button" class="btn btn-flat btn-danger delete-row">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
