<?php

namespace App\Components\Catalog\Interfaces;

interface CurrencyInterface
{
    
    public function calculate(float $number);
    
    public function calculateBack(float $number);
    
    public function format(float $number);
    
    public function formatForAdmin(float $number);
    
    public function microdataName();
    
}
