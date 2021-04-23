<?php

namespace App\Components\Catalog\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface BrandInterface
{
    
    public function rule();
    
    public function linkInAdminPanel(Model $brand): ?string;
    
    public function many(array $brandsIds, ?bool $active = null);
    
}
