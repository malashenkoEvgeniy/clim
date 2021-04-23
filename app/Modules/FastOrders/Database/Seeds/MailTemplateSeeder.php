<?php

namespace App\Modules\FastOrders\Database\Seeds;

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
        $template->name = 'fast_orders::general.mail-templates.names.fast-orders';
        $template->alias = 'fast-orders';
        $template->variables = ['phone' => 'fast_orders::general.mail-templates.attributes.phone'];
        $template->save();
    
        Language::all()->each(function (Language $language) use ($template) {
            $translate = new MailTemplateTranslates();
            $translate->language = $language->slug;
            $translate->row_id = $template->id;
            $translate->subject = 'New fast order';
            $translate->text = 'You have new fast order. User phone {phone}';
            $translate->save();
        });
    }
}
