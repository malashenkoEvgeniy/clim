<?php

namespace App\Modules\Users;

use App\Core\BaseProvider;
use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\Modules\Notifications\Types\NotificationType;
use App\Core\Modules\Settings\Models\Setting;
use App\Core\ObjectValues\LinkObjectValue;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Users\Listeners\NewRegistration;
use App\Modules\Users\Models\User;
use App\Modules\Users\Widgets\Admin\OrderPage;
use App\Modules\Users\Widgets\AreYouClientButton;
use App\Modules\Users\Widgets\AuthPopup;
use App\Modules\Users\Widgets\CheckoutAuthPopup;
use App\Modules\Users\Widgets\ForgotPasswordForm;
use App\Modules\Users\Widgets\HeaderAuthLink;
use App\Modules\Users\Widgets\LoginForm;
use App\Modules\Users\Widgets\MobileAuthLink;
use App\Modules\Users\Widgets\MobileButton;
use App\Modules\Users\Widgets\RegistrationForm;
use App\Modules\Users\Widgets\ShortUserInformation;
use App\Modules\Users\Widgets\Socials;
use App\Modules\Users\Widgets\UserAccountLeftSidebar;
use App\Modules\Users\Widgets\UserAccountMobileMenu;
use App\Modules\Users\Widgets\UserAccountRightSidebar;
use App\Modules\Users\Widgets\UserAccountTopMenu;
use App\Modules\Users\Widgets\UserLiveSearchSelect;
use App\Widgets\Admin\StatCard;
use CustomForm\Group\Group;
use CustomForm\Group\Radio;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use CustomForm\Select;
use Widget, CustomMenu, Config, CustomSettings, CustomRoles, CustomSiteMenu;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\Index
 */
class Provider extends BaseProvider
{

    /**
     * Set custom presets
     */
    protected function presets()
    {
        $this->registerNotificationType(
            NewRegistration::NOTIFICATION_TYPE,
            NewRegistration::NOTIFICATION_ICON,
            NotificationType::COLOR_AQUA
        );

        Config::set('auth.guards.web', [
            'driver' => 'session',
            'provider' => 'users',
        ]);
        Config::set('auth.providers.users', [
            'driver' => 'eloquent',
            'model' => User::class,
        ]);
        Config::set('auth.passwords.users', [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ]);
    }

    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        // Register module configurable settings
        $settings = CustomSettings::createAndGet('users', 'users::settings.group-name');
        $settings->add(
            Input::create('per-page')
                ->setType('number')
                ->setLabel('users::settings.attributes.per-page')
                ->setDefaultValue(User::DEFAULT_USERS_LIMIT)
                ->required(),
            ['required', 'integer', 'min:1']
        );
        $this->socialsLogin();
        // Register left menu block
        $block = CustomMenu::get()->group();
        $block->link(
            'users::general.menu.list',
            RouteObjectValue::make('admin.users.index'),
            'fa fa-users'
        )
            ->addCounter(User::whereActive(false)->count(), 'bg-yellow')
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.users.create'),
                RouteObjectValue::make('admin.users.deleted'),
                RouteObjectValue::make('admin.users.edit')
            )
            ->setPosition(-1000);

        Widget::register(
            new StatCard(
                User::class,
                'users::general.stat-widget-title',
                route('admin.users.index'),
                'users.index',
                StatCard::COLOR_YELLOW,
                'ion-person-add'
            ),
            'users-count',
            'dashboard-fast-stat',
            1
        );
        Widget::register(UserLiveSearchSelect::class, 'live-search-user');
        Widget::register(ShortUserInformation::class, 'short-user-information');
        Widget::register(OrderPage::class, 'users::admin::order-page');

        // Register role scopes
        CustomRoles::add('users', 'users::general.menu.list')->except(RoleRule::VIEW);
    }

    protected function afterBoot()
    {
        // Register right menu block
        $block = CustomSiteMenu::get('account-right');
        $block->link(
            'users::site.menu.right.edit',
            LinkObjectValue::make(route('site.account.edit'))
        );
        $block->link(
            'users::site.menu.right.password',
            LinkObjectValue::make(route('site.account.password'))
        );

        // Register left menu block
        $menu = CustomSiteMenu::get('account-left');
        $menu->link(
            'users::site.menu.left.profile',
            LinkObjectValue::make(route('site.account')),
            'icon-user'
        );

        if (\Schema::hasTable((new Setting)->getTable())) {
            foreach (User::getSettingsForSocialsLogin() as $socialName => $checkSocial) {
                Config::set('services.' . $socialName, [
                    'client_id' => array_get($checkSocial, $socialName . '-api-key'),
                    'client_secret' => array_get($checkSocial, $socialName . '-api-secret'),
                    'redirect' => route('site.social-network', ['alias' => $socialName]),
                ]);
            }
        }

        Widget::register(HeaderAuthLink::class, 'header-auth-link');
        Widget::register(UserAccountRightSidebar::class, 'user-account-right-sidebar');
        Widget::register(UserAccountLeftSidebar::class, 'user-account-left-sidebar');
        Widget::register(UserAccountTopMenu::class, 'user-account-top-menu');
        Widget::register(AuthPopup::class, 'auth-popup');
        Widget::register(LoginForm::class, 'login-form');
        Widget::register(RegistrationForm::class, 'registration-form');
        Widget::register(ForgotPasswordForm::class, 'forgot-password-form');
        Widget::register(Socials::class, 'social-networks');
        Widget::register(MobileButton::class, 'mobile-top-profile-button');
        Widget::register(UserAccountMobileMenu::class, 'users::mobile-menu');
        Widget::register(MobileAuthLink::class, 'users::mobile-auth-link');
        Widget::register(AreYouClientButton::class, 'are-you-client-button');
        Widget::register(CheckoutAuthPopup::class, 'checkout-auth-popup');
    }

    /**
     * @throws \App\Exceptions\WrongParametersException
     */
    private function socialsLogin()
    {
        $settings = CustomSettings::createAndGet('socials-login', 'users::socials-login.settings-name');
        $settings->add(
            Input::create('facebook-api-key')->setLabel('users::socials-login.facebook.api-key'),
            ['nullable', 'required_with:facebook-api-secret', 'string']
        );
        $settings->add(
            Input::create('facebook-api-secret')->setLabel('users::socials-login.facebook.api-secret'),
            ['nullable', 'required_with:facebook-api-key', 'string']
        );
        $settings->add(
            Input::create('twitter-api-key')->setLabel('users::socials-login.twitter.api-key'),
            ['nullable', 'required_with:twitter-api-secret', 'string']
        );
        $settings->add(
            Input::create('twitter-api-secret')->setLabel('users::socials-login.twitter.api-secret'),
            ['nullable', 'required_with:twitter-api-key', 'string']
        );
        $settings->add(
            Input::create('instagram-api-key')->setLabel('users::socials-login.instagram.api-key'),
            ['nullable', 'required_with:instagram-api-secret', 'string']
        );
        $settings->add(
            Input::create('instagram-api-secret')->setLabel('users::socials-login.instagram.api-secret'),
            ['nullable', 'required_with:instagram-api-key', 'string']
        );
    }
}
