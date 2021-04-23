@php
/** @var \App\Modules\Orders\Models\Order $order */
/** @var \CustomForm\Builder\Form $form */
$form->buttons->showCloseButton(route('admin.orders.show', $order->id));
@endphp

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.js-data-ajax').on('select2:select', function (e) {
                var product = e.params.data,
                    $form = $(this).closest('form'),
                    $priceField = $form.find('[name="price"]');
                $priceField.val(product.price);
            });
        });
    </script>
@endpush

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => ['admin.orders.add-item', $order->id]]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
