<?php

namespace App\Modules\Currencies\Components\CurrencyRates;

/**
 * Class CurrencyAbstraction
 *
 * @package App\Modules\Currencies\Components\CurrencyRates
 */
abstract class CurrencyAbstraction
{
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $code;
    
    /**
     * @var float
     */
    protected $rate;
    
    /**
     * @return int
     */
    private function maxDecimal(): int
    {
        return $this->maxDecimal ?? 6;
    }
    
    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @param CurrencyAbstraction $currency
     * @return float
     */
    public function getRateTo(CurrencyAbstraction $currency): float
    {
        return $this->format($this->getRate() / $currency->getRate());
    }
    
    /**
     * @param CurrencyAbstraction $currency
     * @param float $amount
     * @return float
     */
    public function convertTo(CurrencyAbstraction $currency, float $amount): float
    {
        return $this->format($amount * $this->getRateTo($currency));
    }
    
    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }
    
    /**
     * @param float $amount
     * @return float
     */
    public function format(float $amount): float
    {
        return (float)number_format($amount, $this->maxDecimal(), '.', '');
    }
    
}
