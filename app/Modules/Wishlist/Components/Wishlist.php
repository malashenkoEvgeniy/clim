<?php

namespace App\Modules\Wishlist\Components;

use Catalog, Auth;
use Illuminate\Support\Collection;

/**
 * Class Wishlist
 *
 * @package App\Modules\Wishlist\Facades
 */
class Wishlist
{
    
    /**
     * Do we need to use cookies to work with products?
     *
     * @var WishlistInterface
     */
    protected $service;
    
    /**
     * @var Collection
     */
    protected $products;
    
    /**
     * Wishlist constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->products = new Collection();
        if (Auth::guest() || (bool)config('db.wishlist.only-cookies')) {
            $this->service = new WishlistCookies();
        } else {
            $this->service = new WishlistDatabase();
        }
        $this->fillProducts();
    }
    
    /**
     * Fills products list inside current object
     *
     * @throws \Exception
     */
    private function fillProducts(): void
    {
        $productsIds = $this->service->getProductIds();
        if (count($productsIds) === 0) {
            return;
        }
        $this->setProducts($productsIds);
        $this->service->saveProductIds($productsIds, $this->products->toArray());
    }
    
    /**
     * Toggles product id in cookie
     *
     * @param int $productId
     * @throws \Exception
     */
    public function toggle(int $productId): void
    {
        if ($this->has($productId)) {
            $this->remove($productId);
        } else {
            $this->add($productId);
        }
    }
    
    /**
     * @param int $productId
     * @throws \Exception
     */
    public function add(int $productId): void
    {
        $oldProductIds = $this->products->toArray();
        $this->products->push($productId);
        $this->service->saveProductIds(
            $oldProductIds,
            $this->products->toArray()
        );
    }
    
    /**
     * @param int $productId
     * @throws \Exception
     */
    public function remove(int $productId): void
    {
        $currentProductsIds = $this->products->toArray();
        $this->products = $this->products->filter(function (int $productIdFromList) use ($productId) {
            return $productId !== $productIdFromList;
        });
        $this->service->saveProductIds($currentProductsIds, $this->products->toArray());
    }
    
    /**
     * Checks if product is in comparison
     *
     * @param int $productId
     * @return bool
     */
    public function has(int $productId): bool
    {
        return in_array($productId, $this->products->toArray());
    }
    
    /**
     * Returns quantity of unique products in the comparison
     *
     * @return int
     */
    public function count(): int
    {
        return $this->products->count();
    }
    
    /**
     * Returns products list
     *
     * @return array
     */
    public function getProductsIds(): array
    {
        return $this->products->toArray();
    }
    
    /**
     * Sets products list
     *
     * @param array $products
     */
    public function setProducts(array $products): void
    {
        $this->products = new Collection($products);
    }
    
    /**
     * @return WishlistInterface
     */
    public function getService(): WishlistInterface
    {
        return $this->service;
    }
    
    /**
     * @throws \Exception
     */
    public function clear(): void
    {
        $this->service->clear();
        $this->products = new Collection();
    }
}