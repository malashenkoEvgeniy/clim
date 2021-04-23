<?php

namespace App\Modules\Consultations\Database\Seeds;

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
        $template->name = 'consultation::general.mail-templates.names.consultation-admin';
        $template->alias = 'consultation-admin';
        $template->variables = [
            'name' => 'consultation::general.mail-templates.attributes.name',
            'phone' => 'consultation::general.mail-templates.attributes.phone',
            'question' => 'consultation::general.mail-templates.attributes.question',
            'admin_href' => 'consultation::general.mail-templates.attributes.admin_href',
        ];
        $template->save();
    
        Language::all()->each(function (Language $language) use ($template) {
            $translate = new MailTemplateTranslates();
            $translate->language = $language->slug;
            $translate->row_id = $template->id;
            $translate->subject = 'New consultation';
            $translate->text = '<p>You have new consultation request. User name {name} phone {phone}</p><p>Question: {question}</p>';
            $translate->save();
        });
    }
}
