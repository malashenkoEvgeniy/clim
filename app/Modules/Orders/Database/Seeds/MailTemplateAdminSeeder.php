<?php

namespace App\Modules\Orders\Database\Seeds;

use App\Core\Modules\Languages\Models\Language;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Core\Modules\Mail\Models\MailTemplateTranslates;
use App\Modules\Orders\Models\Order;
use Illuminate\Database\Seeder;

class MailTemplateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = new MailTemplate();
        $template->name = 'orders::mail.template.name-admin';
        $template->alias = Order::MAIL_TEMPLATE_ORDER_CREATED_ADMIN;
        $template->variables = [
            'admin_href' => 'orders::general.mail-templates.attributes.admin_href',
        ];
        $template->save();

        Language::all()->each(function (Language $language) use ($template) {
            $translate = new MailTemplateTranslates();
            $translate->language = $language->slug;
            $translate->row_id = $template->id;
            $translate->subject = 'New order at the website!';
            $translate->text = '<p>New order has been created on your web site</p>';
            $translate->save();
        });
    }
}
