<?php

namespace App\Modules\Currencies\Components\CurrencyRates\NBU;

use App\Modules\Currencies\Components\CurrencyRates\CurrencyAbstraction;

/**
 * Class Currency
 *
 * @package App\Modules\Currencies\Components\CurrencyRates\Personal
 */
class Currency extends CurrencyAbstraction
{
    
    /**
     * Currency constructor.
     *
     * @param string $name
     * @param string $code
     * @param float $rate
     */
    public function __construct(string $name, string $code, float $rate)
    {
        $this->name = $name;
        $this->code = $code;
        $this->rate = $rate;
    }
    
}
