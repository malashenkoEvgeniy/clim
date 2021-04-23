<?php

namespace App\Modules\Wishlist\Listeners;

use App\Modules\Wishlist\Components\WishlistCookies;
use App\Modules\Wishlist\Components\WishlistDatabase;

/**
 * Class ViewProductListener
 *
 * @package App\Modules\ProductsViewed\Listeners
 */
class LoginListener
{
    
    /**
     * @param int $userId
     * @throws \Exception
     */
    public function handle(int $userId)
    {
        $cookiesWishlist = new WishlistCookies();
        $productsIdsInCookies = $cookiesWishlist->getProductIds();
        $wishlistDatabaseService = new WishlistDatabase();
        $existedProductsIdsInWishlist = $wishlistDatabaseService->getProductIds();
        $productsIds = array_merge($existedProductsIdsInWishlist, $productsIdsInCookies);
        $wishlistDatabaseService->saveProductIds($existedProductsIdsInWishlist, $productsIds);
        $cookiesWishlist->clear();
    }
}