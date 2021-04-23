<?php

namespace App\Modules\ProductsAvailability\Database\Seeds;

use App\Core\Modules\Languages\Models\Language;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Core\Modules\Mail\Models\MailTemplateTranslates;
use Illuminate\Database\Seeder;

class MailTemplateForUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = new MailTemplate();
        $template->name = 'products-availability::general.mail-templates.names.products-availability-for-user';
        $template->alias = 'products-availability-for-users';
        $template->variables = ['product' => 'products-availability::general.product'];
        $template->save();

        Language::all()->each(function (Language $language) use ($template) {
            $translate = new MailTemplateTranslates();
            $translate->language = $language->slug;
            $translate->row_id = $template->id;
            $translate->subject = 'Товар появился в наличии';
            $translate->text = 'Товар появился в наличии, перейдите по ссылке {product}';
            $translate->save();
        });
    }
}
