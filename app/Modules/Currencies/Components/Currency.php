<?php

namespace App\Modules\Currencies\Components;

use App\Components\Catalog\Interfaces\CurrencyInterface;
use App\Modules\Currencies\Models\Currency as CurrencyModel;

/**
 * Class Currency
 *
 * @package App\Modules\Currencies\Facades
 */
class Currency implements CurrencyInterface
{
    /**
     * @return null|string
     */
    public function microdataName()
    {
        /** @var CurrencyModel $siteCurrency */
        $siteCurrency = config('currency.site');

        return $siteCurrency ? $siteCurrency->microdata : 'UAH';
    }

    /**
     * @return CurrencyModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return CurrencyModel::all();
    }

    public function paginate(int $limit)
    {
        return CurrencyModel::with('current')
            ->oldest('id')
            ->paginate($limit);
    }

    public function oneBySlug(string $name)
    {
        return CurrencyModel::where('slug', $name);
    }

    public function one(int $currencyId)
    {
        return CurrencyModel::whereId($currencyId)->first();
    }

    public function getClassName(): string
    {
        return CurrencyModel::class;
    }

    /**
     * @param float $number
     * @return float
     */
    public function calculate(float $number)
    {
        /** @var CurrencyModel $siteCurrency */
        $siteCurrency = config('currency.site');
        /** @var CurrencyModel $adminCurrency */
        $adminCurrency = config('currency.admin');
        if ($siteCurrency->id !== $adminCurrency->id) {
            $number = ($number / $siteCurrency->multiplier) * $adminCurrency->multiplier;
        }
        return (float)round($number, 2);
    }

    /**
     * @param float $number
     * @return float
     */
    public function calculateBack(float $number): float
    {
        /** @var CurrencyModel $siteCurrency */
        $siteCurrency = config('currency.site');
        /** @var CurrencyModel $adminCurrency */
        $adminCurrency = config('currency.admin');
        if ($siteCurrency->id !== $adminCurrency->id) {
            $number = ($number / $adminCurrency->multiplier) * $siteCurrency->multiplier;
        }
        return (float)round($number, 2);
    }
    
    /**
     * @param float $number
     * @return string
     */
    public function formatWithoutCalculation(float $number)
    {
        /** @var CurrencyModel $siteCurrency */
        $siteCurrency = config('currency.site');
        return $this->setFormat($number, $siteCurrency->sign);
    }

    /**
     * @param float $number
     * @return string
     */
    public function format(float $number)
    {
        /** @var CurrencyModel $siteCurrency */
        $siteCurrency = config('currency.site');
        return $this->setFormat($this->calculate($number), $siteCurrency->sign);
    }

    /**
     * @param float $number
     * @return string
     */
    public function formatForAdmin(float $number)
    {
        /** @var CurrencyModel $siteCurrency */
        $siteCurrency = config('currency.site');
        /** @var CurrencyModel $adminCurrency */
        $adminCurrency = config('currency.admin');
        if ($siteCurrency->id === $adminCurrency->id) {
            return $this->setFormat($number, $adminCurrency->sign);
        }
        return $this->setFormat($number, $adminCurrency->sign) . " ({$this->format($number)})";
    }

    /**
     * @param float $number
     * @param $sign
     * @return string
     */
    public function setFormat(float $number, $sign): string
    {
        $location = config('db.currencies.locations', 'right');
        $numberSymbols = config('db.currencies.number-symbols', 2);
        $type = (int)config('db.currencies.types', 2);

        if ($type === 0) {
            $price = number_format($number, $numberSymbols);
        } elseif ($type === 1) {
            $price = number_format($number, $numberSymbols, ',', ' ');
        } else {
            $price = number_format($number, $numberSymbols, '.', '');
        }

        if ($location === 'left') {
            return $sign . ' ' . $price;
        }
        return $price . ' ' . $sign;
    }

}
