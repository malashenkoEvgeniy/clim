<?php

namespace App\Modules\Currencies\Database\Seeds;

use App\Modules\Currencies\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::truncate();
        
        $currencies = [
            [
                'name' => 'Гривна',
                'sign' => '₴',
                'multiplier' => 1,
                'default_on_site' => true,
                'default_in_admin_panel' => true,
                'microdata' => 'UAH',
            ],
            [
                'name' => 'Евро',
                'sign' => '€',
                'multiplier' => 32.469826,
                'microdata' => 'EUR',
            ],
            [
                'name' => 'Йена',
                'sign' => 'JPY',
                'multiplier' => 0.259946,
                'microdata' => 'JPY',
            ],
            [
                'name' => 'Белорусский рубль',
                'sign' => 'BYN',
                'multiplier' => 13.09298,
                'microdata' => 'BYN',
            ],
            [
                'name' => 'Доллар США',
                'sign' => '$',
                'multiplier' => 28.153842,
                'microdata' => 'USD',
            ],
            [
                'name' => 'Молдовський лей',
                'sign' => 'MDL',
                'multiplier' => 1.644779,
                'microdata' => 'MDL',
            ],
            [
                'name' => 'Российский рубль',
                'sign' => '₽',
                'multiplier' => 0.42073,
                'microdata' => 'RUB',
            ],
            [
                'name' => 'Тенге',
                'sign' => 'KZT',
                'multiplier' => 0.074865,
                'microdata' => 'KZT',
            ],
            [
                'name' => 'Фунт стерлингов',
                'sign' => 'GBP',
                'multiplier' => 36.071572,
                'microdata' => 'GBP',
            ],
            [
                'name' => 'Швейцарский франк',
                'sign' => 'CHF',
                'multiplier' => 28.665866,
                'microdata' => 'CHF',
            ],
        ];
        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
