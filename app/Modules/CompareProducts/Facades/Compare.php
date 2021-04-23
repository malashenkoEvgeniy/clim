<?php

namespace App\Modules\CompareProducts\Facades;

use App\Modules\Products\Models\Product;
use Cookie, Catalog;
use Illuminate\Support\Collection;

/**
 * Class Compare
 *
 * @package App\Modules\CompareProducts\Facades
 */
class Compare
{
    
    const COOKIE_KEY = 'compare';
    
    /**
     * @var Collection
     */
    protected $products;
    
    /**
     * Compare constructor.
     */
    public function __construct()
    {
        $this->products = new Collection();
        $this->fillProducts();
    }
    
    /**
     * Returns arrau with products ids
     *
     * @return array
     */
    private function getProductIdsFromCookies(): array
    {
        $productsIds = request()->cookie(static::COOKIE_KEY, '[]');
        return json_decode($productsIds, true) ?? [];
    }
    
    /**
     * Saves products ids to cookie
     *
     * @param array $productsIds
     */
    private function saveProductIdsToCookies(array $productsIds): void
    {
        Cookie::queue(
            Cookie::forever(
                static::COOKIE_KEY,
                json_encode($productsIds)
            )
        );
    }
    
    /**
     * Fills products list inside current object
     */
    private function fillProducts(): void
    {
        $productsIdsInCookies = $this->getProductIdsFromCookies();
        if (count($productsIdsInCookies) === 0) {
            return;
        }
        // Check products active status & push them to list
        Product::select('id')
            ->whereIn('id', $productsIdsInCookies)
            ->where('active', true)
            ->get()
            ->each(function (Product $product) {
                $this->products->push($product->id);
            });
    }
    
    /**
     * Toggles product id in cookie
     *
     * @param int $productId
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
     * Adds product id to cookies
     *
     * @param int $productId
     */
    public function add(int $productId): void
    {
        $this->products->push($productId);
        $this->saveProductIdsToCookies($this->products->toArray());
    }
    
    /**
     * Removes product id from cookies
     *
     * @param int $productId
     */
    public function remove(int $productId): void
    {
        $this->products = $this->products->filter(function (int $productIdFromList) use ($productId) {
            return $productId !== $productIdFromList;
        });
        $this->saveProductIdsToCookies($this->products->toArray());
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
     * Returns products list
     *
     * @return Collection
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }
    
    /**
     * Sets products list
     *
     * @param Collection $products
     */
    public function setProducts(Collection $products): void
    {
        $this->products = $products;
    }
}
