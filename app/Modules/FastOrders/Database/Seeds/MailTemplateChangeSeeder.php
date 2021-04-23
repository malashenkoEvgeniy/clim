<?php

namespace App\Modules\FastOrders\Database\Seeds;

use App\Core\Modules\Mail\Models\MailTemplate;
use Illuminate\Database\Seeder;

class MailTemplateChangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = MailTemplate::where('alias', 'fast-orders')->first();
        if($template){
            $template->variables = [
                'phone' => 'fast_orders::general.mail-templates.attributes.phone',
                'admin_href' => 'fast_orders::general.mail-templates.attributes.admin_href',
            ];
            $template->save();
        }
    }
}
