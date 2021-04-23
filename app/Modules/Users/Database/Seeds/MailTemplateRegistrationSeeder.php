<?php

namespace App\Modules\Users\Database\Seeds;

use App\Core\Modules\Languages\Models\Language;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Core\Modules\Mail\Models\MailTemplateTranslates;
use Illuminate\Database\Seeder;

class MailTemplateRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = new MailTemplate();
        $template->name = 'users::mail-templates.names.registration';
        $template->alias = 'registration';
        $template->variables = [
            'email' => 'users::mail-templates.attributes.email',
            'password' => 'users::mail-templates.attributes.password',
        ];
        $template->save();
    
        Language::all()->each(function (Language $language) use ($template) {
            $translate = new MailTemplateTranslates();
            $translate->language = $language->slug;
            $translate->row_id = $template->id;
            $translate->subject = 'Registration';
            $translate->text = '<p>You have been successfully registered!</p>';
            $translate->save();
        });
    }
}
