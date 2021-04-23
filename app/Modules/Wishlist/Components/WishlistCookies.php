<?php

namespace App\Modules\Wishlist\Components;

use Cookie;

class WishlistCookies implements WishlistInterface
{
    
    const COOKIE_KEY = 'wishlist';

    public function getProductIds(): array
    {
        $productsIds = request()->cookie(static::COOKIE_KEY, '[]');
        return json_decode($productsIds, true) ?? [];
    }
    
    public function saveProductIds(array $existedProductsIdsInWishlist, array $productsIds): void
    {
        Cookie::queue(
            Cookie::forever(
                static::COOKIE_KEY,
                json_encode($productsIds)
            )
        );
    }
    
    public function clear(): void
    {
        Cookie::queue(Cookie::forget(static::COOKIE_KEY));
    }
    
}