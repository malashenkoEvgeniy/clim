<?php

namespace App\Components\Catalog\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface CategoryInterface
{
    
    public function fillParentsBreadcrumbs(?Model $category = null): void;
    
    public function addMainCategoriesPageBreadcrumb(?string $title = null): void;
    
    public function many(array $ids, ?bool $active = null);
    
}