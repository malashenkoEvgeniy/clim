<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Brands\Models\Brand;
use App\Modules\Products\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CompareProductsList
 *
 * @package App\Modules\Products\Widgets\Site
 */
class CompareProductsList implements AbstractWidget
{
    
    /**
     * @var array
     */
    protected $productsIds;
    
    /**
     * @var array
     */
    protected $category;
    
    /**
     * ProductsList constructor.
     *
     * @param array $productsIds
     * @param array $category [link, id]
     */
    public function __construct(array $productsIds, ?array $category = [])
    {
        $this->productsIds = $productsIds;
        $this->category = $category;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (empty($this->productsIds)) {
            return null;
        }
        $features = new Collection();
        $valuesFeature = new Collection();
        
        $products = Product::with('current', 'brand', 'brand.current')
            ->whereIn('id', $this->productsIds)
            ->whereHas('group', function (Builder $builder) {
                $builder->where('category_id', $this->category['id']);
            })
            ->get();
        $products->each(function (Product $product) use ($valuesFeature, $features) {
            $valuesFeature->put(
                $product->id,
                \Widget::show(
                    'features::compare',
                    $product->feature_values_as_array
                )
            );
        });
        
        $features = [];
        $valuesFeature->each(function (array $elements, int $productId) use (&$features) {
            $features += array_keys($elements);
        });
        
        return view('products::site.widgets.compare-item-list.compare-item-list', [
            'products' => $products,
            'values' => $valuesFeature,
            'categoryLink' => $this->category['link'],
            'features' => array_unique($features),
        ]);
    }
    
}
