<?php

namespace App\Components\Catalog\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface LabelInterface
{
    
    public function rule();
    
    public function linkInAdminPanel(Model $label): ?string;
    
    public function many(array $labelsIds, ?bool $active = null);
    
}
