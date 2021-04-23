<?php

namespace App\Modules\Products\Filters;

use App\Components\Form\ObjectValues\ModelForSelect;
use App\Modules\Brands\Models\Brand;
use App\Modules\Categories\Models\Category;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Select;
use CustomForm\Text;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Widget;

/**
 * Class ArticlesFilter
 *
 * @package App\Core\Modules\Articles\Filters
 */
class ProductsAdminFilter extends ModelFilter
{
    /**
     * Generate form view
     *
     * @return string
     * @throws \App\Exceptions\WrongParametersException
     */
    static function showFilter()
    {
        $form = Form::create();
        $form->fieldSetForFilter()->add(
            Input::create('name')->setValue(request('name'))
                ->addClassesToDiv('col-md-3'),
            Input::create('vendorCode')->setValue(request('vendorCode'))
                ->setLabel('products::general.attributes.vendor_code')
                ->addClassesToDiv('col-md-3'),
            Select::create('category')
                ->add(Category::getDictionaryForSelects())
                ->addClassesToDiv('col-md-2')
                ->setPlaceholder(__('global.all'))
                ->setValue(request('category')),
            Select::create('brand')
                ->addClassesToDiv('col-md-2')
                ->model(ModelForSelect::make(
                    Brand::with('current')->get()
                )->setValueFieldName('current.name'))
                ->setPlaceholder(__('global.all'))
                ->setLabel('validation.attributes.brand_id')
                ->setValue(request()->query('brand')),
            Text::create()->setDefaultValue(
                Widget::show('categories::select-for-filter')
            ),
            Text::create()->setDefaultValue(
                Widget::show('brands::select-for-filter')
            )
        );
        return $form->renderAsFilter();
    }
    
    public function query(string $query)
    {
        $query = Str::lower($query);
        return $this->whereHas('current', function (Builder $db) use ($query) {
            return $db
                ->whereRaw('LOWER(vendor_code) LIKE ?', ["%$query%"])
                ->orWhereRaw('LOWER(name) LIKE ?', ["%$query%"])
                ->orWhereRaw('LOWER(hidden_name) LIKE ?', ["%$query%"]);
        });
    }
    
    /**
     * Filter by name
     *
     * @param  string $name
     * @return ProductsAdminFilter
     */
    public function name(string $name)
    {
        $name = Str::lower($name);
        return $this->related('current', function (Builder $query) use ($name) {
            return $query->whereRaw('LOWER(name) LIKE ?', ["%$name%"]);
        });
    }
    
    /**
     * Filter by category id
     *
     * @param string $categoryId
     * @return ProductsAdminFilter|Builder
     */
    public function category(string $categoryId)
    {
        return $this->whereHas('group.otherCategories', function (Builder $builder) use ($categoryId) {
            $builder->where('category_id', $categoryId);
        });
    }
    
    /**
     * Filter by vendor code
     *
     * @param string $vendorCode
     * @return ProductsAdminFilter|Builder
     */
    public function vendorCode(string $vendorCode)
    {
        return $this->where('products.vendor_code', '=', $vendorCode);
    }
    
    /**
     * Filter by brand id
     *
     * @param string $brandId
     * @return ProductsAdminFilter|Builder
     */
    public function brand(string $brandId)
    {
        return $this->where('brand_id', '=', $brandId);
    }
}
