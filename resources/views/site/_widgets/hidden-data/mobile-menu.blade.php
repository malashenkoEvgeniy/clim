@php
$phone = ($phone = config('db.basic.phone_number_1')) ? '+' . preg_replace("/[^,.0-9]/", '', $phone) : null;

/** @var string[] $mmenuIconTop */
$mmenuIconTop = [
    '<a' . ((Route::currentRouteName() === 'site.home') ? '' : ' href="/"') . ' class="mm-icon-link">' .
        SiteHelpers\SvgSpritemap::get('icon-home') .
    '</a>',
    '<a href="#" class="mm-icon-link js-init" data-mfp="inline" data-mfp-src="#popup-callback">' .
        SiteHelpers\SvgSpritemap::get('icon-phone') .
    '</a>',
    '<a href="#" class="mm-icon-link js-init" data-mfp="inline" data-mfp-src="#popup-consultation">' .
        SiteHelpers\SvgSpritemap::get('icon-ask-doctor') .
    '</a>'
];

/** @var string[] $mmenuIconBottom */
$mmenuIconBottom = [];
$mmenuIconItems = Widget::show('social_buttons::icons-mobile') ?? [];
if ($mmenuIconItems) {
    foreach ($mmenuIconItems['icons'] as $key => $link) {
        if (!empty($link)) {
            $str = '<a target="_blank" class="mm-icon-link mm-icon-link--' . $key . '" href="' . $link . '">' .
                        SiteHelpers\SvgSpritemap::get('icon-network-'.$key) .
                    '</a>';
            array_push($mmenuIconBottom, $str);
        }
    }
}

$options = [
    'type' => 'MenuNav',
    'user-type-options' => [
        'options' => [
            'navbar' => [
                'title' => '',
            ],
            'navbars' => [
                [
                    'position' => 'top',
                    'type' => 'tabs',
                    'content' => [
                        '<a href="#mobile-menu__menu">' . __('site_menu::site.mobile-menu-block') . '</a>'
                    ]
                ]
            ],
            'iconbar' => [
                'add' => true,
                'top' => $mmenuIconTop,
                'bottom' => $mmenuIconBottom,
            ],
        ],
        'configuration' => (object)[],
    ]
];
@endphp
<nav id="mobile-menu" class="js-init" data-mmenu-module='{!! json_encode($options) !!}'>
    <ul id="mobile-menu__menu">
        {!! Widget::show('users::mobile-auth-link') !!}
        {!! Widget::show('categories::mobile-menu') !!}
        {!! Widget::show('site-menu::mobile') !!}
    </ul>
</nav>
