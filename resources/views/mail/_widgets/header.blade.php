<table width="100%" cellspacing="0" cellpadding="0" border="0" style="background: url({{ site_media('static/pic/email-shadow.jpg', true, false, true) }}) repeat-x bottom;">
    <tr>
        <td align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center"><tr><td style="padding:0px; margin:0px;">
            <![endif]-->

            <table align="center" cellspacing="0" cellpadding="0" border="0" style="width:100%; max-width:600px;">
                <tr>
                    <td>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="padding: 10px 0 10px 0;">
                            <tr>
                                <td>
                                    <a href="{{ route('site.home') }}"><img src="{{ site_media('static/images/logo.png', true, false, true) }}" alt="" style="max-width: 150px;"></a>
                                </td>
                                <td>
                                    <p style="font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: bold; text-align: right; padding-right: 10px;">@yield('header')</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!--[if (gte mso 9)|(IE)]>
            </td></tr></table><![endif]-->
        </td>
    </tr>
</table>
