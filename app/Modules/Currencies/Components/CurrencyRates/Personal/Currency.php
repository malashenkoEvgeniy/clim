<?php

namespace App\Modules\Currencies\Components\CurrencyRates\Personal;

use App\Modules\Currencies\Components\CurrencyRates\CurrencyAbstraction;
use App\Modules\Currencies\Models\Currency as CurrencyModel;

/**
 * Class Currency
 * @package App\Modules\Currencies\Components\CurrencyRates\Personal
 */
class Currency extends CurrencyAbstraction
{
    
    /**
     * Currency constructor.
     *
     * @param CurrencyModel $currency
     * @param CurrencyModel $mainCurrency
     */
    public function __construct(CurrencyModel $currency, CurrencyModel $mainCurrency)
    {
        $this->name = $currency->name;
        $this->code = $currency->microdata;
        $this->rate = $this->format($currency->multiplier / $mainCurrency->multiplier);
    }
    
}
