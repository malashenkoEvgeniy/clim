<?php

namespace App\Modules\ProductsAvailability\Database\Seeds;

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
        $template->name = 'products-availability::general.mail-templates.names.products-availability';
        $template->alias = 'products-availability';
        $template->variables = ['email' => 'products_availability::general.mail-templates.attributes.email'];
        $template->save();

        Language::all()->each(function (Language $language) use ($template) {
            $translate = new MailTemplateTranslates();
            $translate->language = $language->slug;
            $translate->row_id = $template->id;
            $translate->subject = 'New availability order';
            $translate->text = 'You have new availability order. User email {email}';
            $translate->save();
        });
    }
}
