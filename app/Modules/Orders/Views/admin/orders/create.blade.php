@php
/** @var \CustomForm\Builder\Form $form */
$form->buttons->showCloseButton(route('admin.orders.index'))
@endphp

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.js-data-ajax').on('select2:select', function (e) {
                var user = e.params.data, $form = $(this).closest('form');
                var $nameInput = $form.find('[name="name"]');
                if (!$nameInput.val()) {
                    $form.find('[name="name"]').val(user.name);
                }
                var $emailInput = $form.find('[name="email"]');
                if (!$emailInput.val()) {
                    $form.find('[name="email"]').val(user.email);
                }
                var $phoneInput = $form.find('[name="phone"]');
                if (user.phone && (!$phoneInput.val() || $phoneInput.val() === '+380')) {
                    $form.find('[name="phone"]').val(user.phone);
                }
            });
        });
    </script>
@endpush

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => 'admin.orders.store']) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
