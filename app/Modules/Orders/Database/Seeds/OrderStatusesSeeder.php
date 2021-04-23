<?php

namespace App\Modules\Orders\Database\Seeds;

use App\Core\Modules\Languages\Models\Language;
use App\Modules\Orders\Models\OrderStatus;
use App\Modules\Orders\Models\OrderStatusTranslates;
use Illuminate\Database\Seeder;

class OrderStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'name' => 'В обработке',
                'alias' => OrderStatus::STATUS_NEW,
                'can_cancel' => false,
                'color' => '#30a9cf',
            ],
            [
                'name' => 'Принят. Ожидает оплаты',
                'can_cancel' => true,
                'color' => '#dbd539',
            ],
            [
                'name' => 'Оплачен. Формируется к отправке',
                'can_cancel' => true,
                'color' => '#3eba4a',
            ],
            [
                'name' => 'Отправлен',
                'can_cancel' => true,
                'color' => '#156b21',
            ],
            [
                'name' => 'Завершен',
                'alias' => OrderStatus::STATUS_DONE,
                'can_cancel' => false,
                'color' => '#bf52e8',
            ],
            [
                'name' => 'Отменен',
                'alias' => OrderStatus::STATUS_CANCELED,
                'can_cancel' => false,
                'color' => '#ff0000',
            ],
        ];

        foreach ($statuses as $i => $status) {
            $template = new OrderStatus();
            $template->position = $i;
            $template->color = $status['color'];
            $template->alias = $status['alias'] ?? null;
            $template->user_can_cancel = $status['can_cancel'];
            $template->save();

            Language::all()->each(function (Language $language) use ($template, $status) {
                $translate = new OrderStatusTranslates();
                $translate->language = $language->slug;
                $translate->row_id = $template->id;
                $translate->name = $status['name'];
                $translate->save();
            });
        }
    }
}
