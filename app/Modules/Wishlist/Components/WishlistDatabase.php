<?php

namespace App\Modules\Wishlist\Components;

use App\Modules\Wishlist\Models\Wishlist as Wishlist;
use Auth;

class WishlistDatabase implements WishlistInterface
{
    
    public function getProductIds(): array
    {
        $productsIds = [];
        Wishlist::select('product_id')
            ->whereUserId(Auth::id())
            ->get()
            ->each(function (Wishlist $wishlist) use (&$productsIds) {
                $productsIds[] = $wishlist->product_id;
            });
        return $productsIds;
    }

    /**
     * @param array $existedProductsIdsInWishlist
     * @param array $productsIds
     * @throws \Exception
     */
    public function saveProductIds(array $existedProductsIdsInWishlist, array $productsIds): void
    {
        foreach ($productsIds as $productId) {
            if (in_array($productId, $existedProductsIdsInWishlist) === false) {
                Wishlist::linkProductToUser($productId, Auth::id());
            }
        }
        foreach ($existedProductsIdsInWishlist as $productId) {
            if (in_array($productId, $productsIds) === false) {
                Wishlist::unlinkProductFromUser($productId, Auth::id());
            }
        }
    }
    
    /**
     * @throws \Exception
     */
    public function clear(): void
    {
        Wishlist::clear(Auth::id());
    }
    
}