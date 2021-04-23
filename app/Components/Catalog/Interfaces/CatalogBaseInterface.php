<?php

namespace App\Components\Catalog\Interfaces;

interface CatalogBaseInterface
{
    const DEFAULT_PAGINATION_LIMIT = 10;
    
    public function all(?bool $active = null);
    
    public function paginate(int $limit, ?bool $active = null);
    
    public function one(int $id, ?bool $active = null);
    
    public function oneBySlug(string $slug, ?bool $active = null);
    
    public function getQuery(?bool $active = null);
    
    public function getClassName(): string;
    
    public function getTableName(): string;
}