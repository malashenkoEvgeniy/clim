<?php

namespace App\Modules\Wishlist\Components;

/**
 * Interface WishlistInterface
 *
 * @package App\Modules\Wishlist\Facades
 * @property-read $products
 */
interface WishlistInterface
{

    function getProductIds(): array;
    
    function saveProductIds(array $existedProductsIdsInWishlist, array $productsIds): void;
    
    function clear(): void;

}