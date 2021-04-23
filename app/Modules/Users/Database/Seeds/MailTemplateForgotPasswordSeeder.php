<?php

namespace App\Modules\Users\Database\Seeds;

use App\Core\Modules\Languages\Models\Language;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Core\Modules\Mail\Models\MailTemplateTranslates;
use Illuminate\Database\Seeder;

class MailTemplateForgotPasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = new MailTemplate();
        $template->name = 'users::mail-templates.names.forgot-password';
        $template->alias = 'forgot-password';
        $template->variables = [
            'email' => 'users::mail-templates.attributes.email',
            'link' => 'users::mail-templates.attributes.link',
        ];
        $template->save();
    
        Language::all()->each(function (Language $language) use ($template) {
            $translate = new MailTemplateTranslates();
            $translate->language = $language->slug;
            $translate->row_id = $template->id;
            $translate->subject = 'Forgot password';
            $translate->text = '<p>This is <a href="{link}">your link</a> to reset password:</p>';
            $translate->save();
        });
    }
}
