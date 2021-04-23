<?php

namespace App\Modules\Orders\Database\Seeds;

use App\Core\Modules\Languages\Models\Language;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Core\Modules\Mail\Models\MailTemplateTranslates;
use App\Modules\Orders\Models\Order;
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
        $template->name = 'orders::mail.template.name';
        $template->alias = Order::MAIL_TEMPLATE_ORDER_CREATED;
        $template->variables = [];
        $template->save();
    
        Language::all()->each(function (Language $language) use ($template) {
            $translate = new MailTemplateTranslates();
            $translate->language = $language->slug;
            $translate->row_id = $template->id;
            $translate->subject = 'Новый заказ!';
            $translate->text = '<p>Спасибо за Ваше доверие! Подробности заказа приведены ниже:</p>';
            $translate->save();
        });
    }
}
