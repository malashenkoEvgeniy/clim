<?php

namespace App\Modules\Currencies\Components\CurrencyRates\NBU;

use App\Modules\Currencies\Components\CurrencyRates\AggregatorAbstraction;
use App\Helpers\Emitter;
use App\Modules\Currencies\Components\CurrencyRates\Rate;
use Illuminate\Support\Collection;

/**
 * Class NBU
 *
 * @package App\Modules\Currencies\Components\CurrencyRates\NBU
 */
class NBU extends AggregatorAbstraction
{
    /**
     * NBU constructor.
     *
     * @param string $name
     * @param string $code
     * @param float $rate
     */
    public function __construct(string $name, string $code, float $rate)
    {
        $this->currencies = new Collection();
        $courses = Emitter::get('https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?date=' . date('Ymd') . '&json');
        if (is_array($courses)) {
            foreach ($courses as $course) {
                if (in_array($course['cc'], Rate::getExistedCurrenciesCodes()) === false) {
                    continue;
                }
                $this->currencies->put($course['cc'], new Currency($course['txt'], $course['cc'], $course['rate']));
            }
        }
        if ($this->currencies->has($code) === false) {
            $this->currencies->put($code, new Currency($name, $code, $rate));
        }
        if ($this->currencies->has(Rate::CURRENCY_UAH) === false) {
            $this->currencies->put(Rate::CURRENCY_UAH, new Currency('Гривна', Rate::CURRENCY_UAH, 1));
        }
    }
}
