<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('subject')</title>
    <style type="text/css">
        @media (max-width: 430px) {
            .product-name {
                font-size: 10px;
            }
            .product-price {
                font-size: 10px;
            }
            .button-link {
                font-size: 10px;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0;">
<div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">
    {{ $subject }} | {{ config('db.basic.company') }}
</div>
@include('mail._widgets.header')

<table width="100%" cellspacing="0" cellpadding="0" border="0" style="background: #ebedef;">
    <tr>
        <td align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center"><tr><td style="padding:0px; margin:0px;">
            <![endif]-->

            <table align="center" cellspacing="0" cellpadding="0" border="0" style="width:100%; max-width:600px; padding: 10px 0 25px 0;">
                <tr>
                    <td>
                        <table width="100%" align="center" cellspacing="0" cellpadding="0" border="0" style="background-color: #ffffff; padding: 15px; box-shadow: 0 0 15px rgba(0,0,0,0.1); border-radius: 2px; border: 1px solid #ededef;">
                            @stack('before-content')
                            <tr>
                                <td style="padding-top: 20px;">
                                    @yield('content')
                                </td>
                            </tr>
                            @stack('after-content')
                        </table>
                    </td>
                </tr>
            </table>

            <!--[if (gte mso 9)|(IE)]>
            </td></tr></table><![endif]-->
        </td>
    </tr>
</table>

@include('mail._widgets.footer')
</body>
</html>
