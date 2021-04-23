<?php

namespace App\Modules\Callback\Database\Seeds;

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
        $template->name = 'callback::general.mail-templates.names.callback-admin';
        $template->alias = 'callback-admin';
        $template->variables = [
            'name' => 'callback::general.mail-templates.attributes.name',
            'phone' => 'callback::general.mail-templates.attributes.phone',
            'admin_href' => 'callback::general.mail-templates.attributes.admin_href',
        ];
        $template->save();
    
        Language::all()->each(function (Language $language) use ($template) {
            $translate = new MailTemplateTranslates();
            $translate->language = $language->slug;
            $translate->row_id = $template->id;
            $translate->subject = 'New callback';
            $translate->text = 'You have new callback request. User name {name} phone {phone}';
            $translate->save();
        });
    }
}
