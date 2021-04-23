<?php

namespace App\Core\Modules\Mail;

use App\Components\Settings\SettingsGroup;
use App\Core\BaseProvider;
use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\ObjectValues\RouteObjectValue;
use App\Rules\Domain;
use CustomForm\Input;
use CustomForm\TextArea;
use CustomForm\Macro\Toggle;
use CustomForm\Select;
use CustomSettings,
    CustomRoles,
    CustomMenu;
use Illuminate\Validation\Rule;

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
        $this->setModuleName('mail_templates');
        $this->setTranslationsNamespace('mail_templates');
        $this->setViewNamespace('mail_templates');
        $this->setConfigNamespace('mail_templates');
    }

    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        // Register module configurable settings
        $settings = CustomSettings::createAndGet('mail_templates', 'mail_templates::settings.name');
        $settings->add(
                Input::create('per-page')->setLabel('mail_templates::settings.attributes.per-page'), ['required', 'integer', 'min:1']
        );
        // Menu element
        CustomMenu::get()->group('system')
                ->link('mail_templates::menu.name', RouteObjectValue::make('admin.mail_templates.index'), 'glyphicon glyphicon-envelope');
        // Register role scopes
        CustomRoles::add('mail_templates', 'mail_templates::general.permission-name')
                ->only(RoleRule::INDEX, RoleRule::UPDATE);
        // Additional settings list
        $this->mailSettings();
        $this->basicSettings();
    }

    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
    
    }

    /**
     * Adding settings for mail
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    private function mailSettings()
    {
        $settings = CustomSettings::createAndGet('mail', 'mail_templates::mail.settings-name', -9999);
        $masterField = $settings->add(
            Select::create('driver')
                ->add([
                    'smtp' => 'mail_templates::mail.drivers.smtp',
                    'mailgun' => 'mail_templates::mail.drivers.mailgun',
                    'mandrill' => 'mail_templates::mail.drivers.mandrill',
                    'sparkpost' => 'mail_templates::mail.drivers.sparkpost',
                    'sendpulse' => 'mail_templates::mail.drivers.sendpulse',
                ])
                ->setLabel('mail_templates::mail.attributes.driver')
                ->required(), ['required', Rule::in(['smtp', 'mailgun', 'mandrill', 'sparkpost', 'sendpulse'])], -9999
        )->masterField();
        $this->smtp($settings, $masterField->getFormElement()->getName(), 'smtp');
        $this->mailgun($settings, $masterField->getFormElement()->getName(), 'mailgun');
        $this->mandrill($settings, $masterField->getFormElement()->getName(), 'mandrill');
        $this->sparkpost($settings, $masterField->getFormElement()->getName(), 'sparkpost');
        $this->sendpulse($settings, $masterField->getFormElement()->getName(), 'sendpulse');
    }

    /**
     * Add dependent fields
     * Settings for SMTP
     *
     * @param SettingsGroup $settings
     * @param string $masterFieldName
     * @param string $masterFieldValue
     * @throws \App\Exceptions\WrongParametersException
     */
    private function smtp(SettingsGroup $settings, string $masterFieldName, string $masterFieldValue)
    {
        // SMTP host
        $settings->add(
                Input::create('smtp_host')
                        ->setLabel('mail_templates::mail.attributes.smtp_host')
                        ->required(), ["required_if:$masterFieldName,$masterFieldValue", 'nullable', new Domain()]
        )->dependent($masterFieldName, $masterFieldValue);
        // SMTP port
        $settings->add(
                Input::create('smtp_port')
                        ->setLabel('mail_templates::mail.attributes.smtp_port')
                        ->required(), ["required_if:$masterFieldName,$masterFieldValue", 'nullable', 'integer', 'min:0', 'max:99999']
        )->dependent($masterFieldName, $masterFieldValue);
        // SMTP login
        $settings->add(
                Input::create('smtp_login')
                        ->setLabel('mail_templates::mail.attributes.smtp_login')
                        ->required(), ["required_if:$masterFieldName,$masterFieldValue", 'nullable', 'string']
        )->dependent($masterFieldName, $masterFieldValue);
        // SMTP password
        $settings->add(
                Input::create('smtp_password')
                        ->setLabel('mail_templates::mail.attributes.smtp_password')
                        ->required(), ["required_if:$masterFieldName,$masterFieldValue", 'nullable', 'string']
        )->dependent($masterFieldName, $masterFieldValue);
        // From email
        $settings->add(
            Input::create('smtp_from_email')
                ->setType('email')
                ->setLabel('mail_templates::mail.attributes.smtp_from_email')
                ->required(), ["required_if:$masterFieldName,$masterFieldValue", 'nullable', 'email']
        )->dependent($masterFieldName, $masterFieldValue);
        // Encryption
        $settings->add(
            Select::create('smtp_encryption')
                ->add([
                    'tls' => 'mail_templates::mail.encryptions.tls',
                    'ssl' => 'mail_templates::mail.encryptions.ssl',
                ])
                ->setPlaceholder('&mdash;')
                ->setLabel('mail_templates::mail.attributes.smtp_encryption'),
            ['nullable', Rule::in(['tls', 'ssl'])]
        )->dependent($masterFieldName, $masterFieldValue);
        // From name
        $settings->add(
                Input::create('smtp_from_name')
                        ->setLabel('mail_templates::mail.attributes.smtp_from_name')
                        ->required(), ["required_if:$masterFieldName,$masterFieldValue", 'nullable', 'string']
        )->dependent($masterFieldName, $masterFieldValue);
    }

    /**
     * Add dependent fields
     * Settings for Mailgun
     * See: https://www.mailgun.com
     *
     * @param SettingsGroup $settings
     * @param string $masterFieldName
     * @param string $masterFieldValue
     * @throws \App\Exceptions\WrongParametersException
     */
    private function mailgun(SettingsGroup $settings, string $masterFieldName, string $masterFieldValue)
    {
        // Mailgun domain
        $settings->add(
                Input::create('mailgun_domain')
                        ->setLabel('mail_templates::mail.attributes.mailgun_domain')
                        ->required(), ["required_if:$masterFieldName,$masterFieldValue", 'nullable', 'string']
        )->dependent($masterFieldName, $masterFieldValue);
        // Mailgun secret
        $settings->add(
                Input::create('mailgun_secret')
                        ->setLabel('mail_templates::mail.attributes.mailgun_secret')
                        ->required(), ["required_if:$masterFieldName,$masterFieldValue", 'nullable', 'string']
        )->dependent($masterFieldName, $masterFieldValue);
    }

    /**
     * Add dependent fields
     * Settings for Mandrill
     * See: https://www.mandrill.com/
     *
     * @param SettingsGroup $settings
     * @param string $masterFieldName
     * @param string $masterFieldValue
     * @throws \App\Exceptions\WrongParametersException
     */
    private function mandrill(SettingsGroup $settings, string $masterFieldName, string $masterFieldValue)
    {
        // Mandrill secret
        $settings->add(
                Input::create('mandrill_secret')
                        ->setLabel('mail_templates::mail.attributes.mandrill_secret')
                        ->required(), ["required_if:$masterFieldName,$masterFieldValue", 'nullable', 'string']
        )->dependent($masterFieldName, $masterFieldValue);
    }

    /**
     * Add dependent fields
     * Settings for Sparkpost
     * See: https://www.sparkpost.com
     *
     * @param SettingsGroup $settings
     * @param string $masterFieldName
     * @param string $masterFieldValue
     * @throws \App\Exceptions\WrongParametersException
     */
    private function sparkpost(SettingsGroup $settings, string $masterFieldName, string $masterFieldValue)
    {
        // Sparkpost secret
        $settings->add(
                Input::create('sparkpost_secret')
                        ->setLabel('mail_templates::mail.attributes.sparkpost_secret')
                        ->required(), ["required_if:$masterFieldName,$masterFieldValue", 'nullable', 'string']
        )->dependent($masterFieldName, $masterFieldValue);
    }

    /**
     * @param SettingsGroup $settings
     * @param string $masterFieldName
     * @param string $masterFieldValue
     * @throws \App\Exceptions\WrongParametersException
     */
    private function sendpulse(SettingsGroup $settings, string $masterFieldName, string $masterFieldValue)
    {
        $settings->add(
                Input::create('sendpulse_user_id')
                        ->setLabel('mail_templates::mail.attributes.sendpulse_user_id')
                        ->required(), ["required_if:$masterFieldName,$masterFieldValue", 'nullable', 'string']
        )->dependent($masterFieldName, $masterFieldValue);
        $settings->add(
                Input::create('sendpulse_secret')
                        ->setLabel('mail_templates::mail.attributes.sendpulse_secret')
                        ->required(), ["required_if:$masterFieldName,$masterFieldValue", 'nullable', 'string']
        )->dependent($masterFieldName, $masterFieldValue);
        $settings->add(
                Input::create('sendpulse_from_email')
                        ->setType('email')
                        ->setLabel('mail_templates::mail.attributes.sendpulse_from_email')
                        ->required(), ["required_if:$masterFieldName,$masterFieldValue", 'nullable', 'email']
        )->dependent($masterFieldName, $masterFieldValue);
        $settings->add(
                Input::create('sendpulse_from_name')
                        ->setLabel('mail_templates::mail.attributes.sendpulse_from_name')
                        ->required(), ["required_if:$masterFieldName,$masterFieldValue", 'nullable', 'string']
        )->dependent($masterFieldName, $masterFieldValue);
    }

    /**
     * @throws \App\Exceptions\WrongParametersException
     */
    private function basicSettings()
    {
        // Register module configurable settings
        $settings = CustomSettings::createAndGet('basic', 'mail_templates::basic.settings-name', -9999);
        $settings->add(
            Input::create('admin_email')
                ->setLabel('mail_templates::basic.attributes.admin-email')
                ->required(), ['required', 'email', 'min:5']
        );
    }

}
