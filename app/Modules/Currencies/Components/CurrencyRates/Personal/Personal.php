<?php

namespace App\Modules\Currencies\Components\CurrencyRates\Personal;

use App\Modules\Currencies\Components\CurrencyRates\AggregatorAbstraction;
use App\Modules\Currencies\Models\Currency as CurrencyModel;
use Illuminate\Support\Collection;

/**
 * Class Personal
 *
 * @package App\Modules\Currencies\Components\CurrencyRates\Personal
 */
class Personal extends AggregatorAbstraction
{
    /**
     * Personal constructor.
     *
     * @param CurrencyModel $mainCurrency
     */
    public function __construct(CurrencyModel $mainCurrency)
    {
        $this->currencies = new Collection();
        CurrencyModel::all()->each(function (CurrencyModel $currency) use ($mainCurrency) {
            $this->currencies->put($currency->microdata, new Currency($currency, $mainCurrency));
        });
    }
}
