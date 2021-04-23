<?php

namespace App\Providers;

use Config;
use Illuminate\Support\ServiceProvider;

/**
 * Class MailServiceProvider
 * Mail configurations
 *
 * @package App\Providers
 */
class MailServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $driver = config('db.mail.driver');
        if ($driver && method_exists($this, $driver)) {
            Config::set('mail.driver', $driver);
            $this->{$driver}();
        }
    }
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
    
    /**
     * Sets SMTP mail settings as current
     */
    public function smtp()
    {
        Config::set('mail.from.address', config('db.mail.smtp_from_email'));
        Config::set('mail.from.name', config('db.mail.smtp_from_name'));
        Config::set('mail.host', config('db.mail.smtp_host'));
        Config::set('mail.port', config('db.mail.smtp_port'));
        Config::set('mail.username', config('db.mail.smtp_login'));
        Config::set('mail.password', config('db.mail.smtp_password'));
        Config::set('mail.encryption', config('db.mail.smtp_encryption'));
    }
    
    /**
     * Sets Mailgun mail settings as current
     */
    public function mailgun()
    {
        Config::set('mail.mailgun.domain', config('db.mail.mailgun_domain'));
        Config::set('mail.mailgun.secret', config('db.mail.mailgun_secret'));
    }
    
    /**
     * Sets Mandrill mail settings as current
     */
    public function mandrill()
    {
        Config::set('mail.mandrill.secret', config('db.mail.mandrill_secret'));
    }
    
    /**
     * Sets Sparkpost mail settings as current
     */
    public function sparkpost()
    {
        Config::set('mail.sparkpost.secret', config('db.mail.sparkpost_secret'));
    }
    
}
