<table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #ededef; padding: 0 0 20px 0;">
    <tr>
        <td align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center">
                <tr>
                    <td style="padding:0px; margin:0px;">
            <![endif]-->

            <table align="center" cellspacing="0" cellpadding="0" border="0" style="width:100%; max-width:600px;">
                <tr>
                    <td>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-family: 'Open Sans', sans-serif; font-weight: 600; font-size: 13px;">
                            <tr>
                                <td>
                                    <a href="{{ route('site.home') }}"><img src="{{ site_media('static/images/logo.png', true, false, true) }}" alt="" style="max-width: 150px;"></a>
                                </td>
                                <td>
                                    <table cellspacing="0" cellpadding="0" border="0" align="right">
                                        <tr>
                                            <td style="padding-right: 10px;">
                                                @lang('emails.soc_title')
                                            </td>
                                            @php($icons = Widget::show('social_buttons::icons-mobile') ?? [])
                                            @foreach(array_get($icons, 'icons', []) as $key => $link)
                                                <td style="padding-right: 10px;">
                                                    <a href="{{ $link }}" title="@lang("social_buttons::site.icon-labels.$key")" data-title="@lang("social_buttons::site.icon-labels.$key")">
                                                        <img src="{{ site_media('static/images/icons/'.$key.'.png', true, false, true) }}" alt="@lang("social_buttons::site.icon-labels.$key")">
                                                    </a>
                                                </td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 11px; line-height: 1.4em; color: #a0a1a2; text-align: center; padding-top: 10px;">
                        <p>{{ config('db.basic.copyright') }} <br> &copy; {{ config('db.basic.company') }}</p>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td></tr></table><![endif]-->
        </td>
    </tr>
    <tr>
        <td style="font-size: 1px;color: #ededef;">{{ date('Y.m.d H:i:s') }}</td>
    </tr>
</table>
