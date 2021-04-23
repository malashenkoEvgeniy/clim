<?php

namespace App\Modules\Reviews\Database\Seeds;

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
        $template->name = 'reviews::general.mail-templates.names.reviews-admin';
        $template->alias = 'reviews-admin';
        $template->variables = [
            'name' => 'reviews::general.mail-templates.attributes.name',
            'email' => 'reviews::general.mail-templates.attributes.email',
            'comment' => 'reviews::general.mail-templates.attributes.comment',
            'admin_href' => 'reviews::general.mail-templates.attributes.admin_href',
        ];
        $template->save();
    
        Language::all()->each(function (Language $language) use ($template) {
            $translate = new MailTemplateTranslates();
            $translate->language = $language->slug;
            $translate->row_id = $template->id;
            $translate->subject = 'New review';
            $translate->text = '<p>You have new review. User name {name} phone {phone}</p><p>Comment: {comment}</p>';
            $translate->save();
        });
    }
}
