<?php

namespace App\Modules\Subscribe\Database\Seeds;

use App\Core\Modules\Languages\Models\Language;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Core\Modules\Mail\Models\MailTemplateTranslates;
use Illuminate\Database\Seeder;

class MailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = new MailTemplate();
        $template->name = 'subscribe::general.mail-templates.names.subscribe';
        $template->alias = 'subscription';
        $template->variables = [
            'email' => 'subscribe::general.mail-templates.attributes.email',
            'unsubscribe' => 'general::mail-templates.names.unsubscribe'
        ];
        $template->save();
    
        Language::all()->each(function (Language $language) use ($template) {
            $translate = new MailTemplateTranslates();
            $translate->language = $language->slug;
            $translate->row_id = $template->id;
            $translate->subject = 'Subscription';
            $translate->text = '<p>You have been successfully subscribed!</p>';
            $translate->save();
        });
    }
}
