<?php

namespace App\Components\Catalog\Interfaces;

interface FeatureInterface
{
    
    public function getClassName(): string;
    
    public function getTableName(): string;
    
    public function productsFeatures(array $featuresAndValuesForProducts): array;
    
    public function productMainFeatures(array $featuresAndValues): ?string;
    
}
