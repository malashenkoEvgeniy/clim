<!doctype html>
<html lang="{{ Lang::getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@lang('orders::site.liqpay.title')</title>
</head>
<body onload="document.getElementById('process-payment').submit()">
<h1>@lang('orders::site.liqpay.text')</h1>
{!! $form !!}
</body>
</html>
