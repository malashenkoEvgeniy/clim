<?php

namespace App\Traits;

/**
 * Trait ActiveScopeTrait
 *
 * @package App\Traits
 */
trait ActiveScopeTrait
{
    
    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  bool $active
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query, bool $active = true)
    {
        return $query->where('active', $active);
    }
    
}