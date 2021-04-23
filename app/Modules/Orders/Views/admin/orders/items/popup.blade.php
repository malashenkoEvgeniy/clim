@extends('admin.layouts.popup')

@section('content')
    <script>
        $(document).ajaxComplete(function (event, jqxhr) {
            var response = prepareIncomingData(jqxhr.responseJSON);
            if (!response) {
                return false;
            }
            if (response.insert !== undefined) {
                $('#feature-values-list').html(response.insert);
            }
        });
        initAjaxSelect2();
        $('body').find('.js-data-ajax').on('select2:select', function (e) {
            var product = e.params.data,
                $form = $(this).closest('form'),
                $priceField = $form.find('[name="price"]');
            $priceField.val(product.price);
        });
    </script>

    {!! Form::open(['id' => $formId, 'url' => $url, 'class' => 'ajax-form', 'method' => $method ?? 'POST']) !!}
        {!! $form->render() !!}
    {!! Form::close() !!}
    {!! $validation->render() !!}
@stop
