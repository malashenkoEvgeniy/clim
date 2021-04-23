<?php

namespace App\Modules\Currencies\Components\CurrencyRates;

use App\Modules\Currencies\Components\CurrencyRates\NBU\NBU;
use App\Modules\Currencies\Components\CurrencyRates\Personal\Personal;
use App\Modules\Currencies\Models\Currency;
use Illuminate\Support\Collection;

/**
 * Class Rate
 *
 * @package Appp\Components\CurrencyRates
 */
class Rate
{
    const AGGREGATOR_NBU = 'NBU';
    const AGGREGATOR_PERSONAL = 'Personal';
    
    const CURRENCY_UAH = 'UAH';
    const CURRENCY_USD = 'USD';
    const CURRENCY_EUR = 'EUR';
    const CURRENCY_RUB = 'RUB';
    const CURRENCY_CHF = 'CHF';
    const CURRENCY_GBP = 'GBP';
    const CURRENCY_JPY = 'JPY';
    const CURRENCY_PLZ = 'PLZ';
    const CURRENCY_BYN = 'BYN';
    const CURRENCY_KZT = 'KZT';
    const CURRENCY_MDL = 'MDL';
    
    /**
     * @var Currency|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    private $mainCurrency;
    
    /**
     * @var Rate
     */
    private static $instance;
    
    /**
     * @var Collection
     */
    private static $aggregators;
    
    /**
     * Rate constructor.
     */
    public function __construct()
    {
        $this->mainCurrency = Currency::whereDefaultInAdminPanel(true)->firstOrFail();
        static::$aggregators = new Collection();
    }
    
    /**
     * @return Rate
     */
    public static function instance(): Rate
    {
        if (!static::$instance) {
            static::$instance = new Rate;
        }
        return static::$instance;
    }
    
    /**
     * @param string|null $aggregator
     * @return AggregatorAbstraction
     */
    public static function aggregator(?string $aggregator = null): AggregatorAbstraction
    {
        return static::instance()->getAggregator($aggregator);
    }
    
    /**
     * @param float $amount
     * @param string $codeFrom
     * @param string|null $codeTo
     * @param string|null $aggregator
     * @return float
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function convert(float $amount, string $codeFrom, ?string $codeTo = null, ?string $aggregator = null): float
    {
        return static::aggregator($aggregator)->convert($amount, $codeFrom, $codeTo ?? Rate::instance()->mainCurrency->microdata);
    }
    
    /**
     * @return string
     */
    public function getMainCurrencyCode(): string
    {
        return $this->mainCurrency->microdata;
    }
    
    /**
     * @param string|null $aggregator
     * @return AggregatorAbstraction
     */
    public function getAggregator(?string $aggregator = null): AggregatorAbstraction
    {
        switch ($aggregator) {
            case static::AGGREGATOR_NBU:
                if (static::$aggregators->has(static::AGGREGATOR_NBU) === false) {
                    static::$aggregators->put(static::AGGREGATOR_NBU, new NBU(
                        $this->mainCurrency->name,
                        $this->mainCurrency->microdata,
                        $this->mainCurrency->multiplier
                    ));
                }
                return static::$aggregators->get(static::AGGREGATOR_NBU);
            case static::AGGREGATOR_PERSONAL:
            default:
                if (static::$aggregators->has(static::AGGREGATOR_PERSONAL) === false) {
                    static::$aggregators->put(static::AGGREGATOR_PERSONAL, new Personal($this->mainCurrency));
                }
                return static::$aggregators->get(static::AGGREGATOR_PERSONAL);
        }
    }
    
    /**
     * @return array
     */
    public static function getExistedCurrenciesCodes(): array
    {
        return [
            static::CURRENCY_UAH,
            static::CURRENCY_USD,
            static::CURRENCY_EUR,
            static::CURRENCY_RUB,
            static::CURRENCY_CHF,
            static::CURRENCY_GBP,
            static::CURRENCY_JPY,
            static::CURRENCY_PLZ,
            static::CURRENCY_BYN,
            static::CURRENCY_KZT,
            static::CURRENCY_MDL,
        ];
    }
}
