<?php

namespace App\Modules\Products\Listeners;

use App\Core\Interfaces\ListenerInterface;
use App\Modules\Products\Models\ProductCategory;

/**
 * Class SyncCategories
 *
 * @package App\Modules\Categories\Listeners
 */
class SyncWithCategories implements ListenerInterface
{
    
    /**
     * @return string
     */
    public static function listens(): string
    {
        return 'products::saved';
    }
    
    /**
     * @param int $productId
     * @throws \Exception
     */
    public function handle(int $productId)
    {
        $categoriesIds = (array)request()->input('categories', []);
        $mainCategoryId = request()->input('main-category');
        if (!$mainCategoryId && count($categoriesIds) > 0) {
            $mainCategoryId = array_shift($categoriesIds);
        }
        if ($mainCategoryId && in_array($mainCategoryId, $categoriesIds) === false) {
            $categoriesIds[] = $mainCategoryId;
        }
        if (!$mainCategoryId) {
            ProductCategory::whereProductId($productId)->delete();
        } else {
            ProductCategory::whereProductId($productId)
                ->whereNotIn('category_id', $categoriesIds ?: [0])
                ->delete();
            foreach ($categoriesIds as $categoryId) {
                ProductCategory::whereProductId($productId)
                    ->whereCategoryId($categoryId)
                    ->firstOrCreate([
                        'product_id' => $productId,
                        'category_id' => $categoryId,
                        'main' => $categoryId === $mainCategoryId,
                    ]);
            }
            ProductCategory::whereProductId($productId)
                ->where('category_id', '!=', $mainCategoryId)
                ->whereMain(true)
                ->update(['main' => false]);
        }
    }

}