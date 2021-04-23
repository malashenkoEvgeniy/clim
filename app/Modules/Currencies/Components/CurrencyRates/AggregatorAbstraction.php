<?php

namespace App\Modules\Currencies\Components\CurrencyRates;

use App\Exceptions\WrongParametersException;
use Illuminate\Support\Collection;

/**
 * Class AggregatorAbstraction
 *
 * @package App\Modules\Currencies\Components\CurrencyRates
 */
abstract class AggregatorAbstraction
{
    /**
     * @var Collection|CurrencyAbstraction[]
     */
    protected $currencies;
    
    /**
     * @return Collection
     */
    public function getRates(): Collection
    {
        return $this->currencies;
    }
    
    /**
     * @param string $code
     * @return CurrencyAbstraction
     * @throws WrongParametersException
     */
    public function getRate(string $code): CurrencyAbstraction
    {
        if ($this->currencies->has($code) === false) {
            throw new WrongParametersException("Currency $code does not exist!");
        }
        return $this->currencies->get($code);
    }
    
    /**
     * @param float $amount
     * @param string $codeFrom
     * @param string $codeTo
     * @return float
     * @throws WrongParametersException
     */
    public function convert(float $amount, string $codeFrom, string $codeTo): float
    {
        return $this->convertObjects($amount, $this->getRate($codeFrom), $this->getRate($codeTo));
    }
    
    /**
     * @param CurrencyAbstraction $currencyFrom
     * @param CurrencyAbstraction $currencyTo
     * @param float $amount
     * @return float
     */
    public function convertObjects(float $amount, CurrencyAbstraction $currencyFrom, CurrencyAbstraction $currencyTo): float
    {
        return $currencyFrom->convertTo($currencyTo, $amount);
    }
    
}
