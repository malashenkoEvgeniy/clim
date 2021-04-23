<?php

namespace App\Modules\Products\Models;

use App\Modules\Features\Models\FeatureValue;
use App\Rules\MultilangSlug;
use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Validator;

/**
 * App\Modules\Products\Models\ProductTranslates
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $row_id
 * @property string $language
 * @property string|null $h1
 * @property string|null $title
 * @property string|null $keywords
 * @property string|null $description
 * @property string|null $seo_text
 * @property string|null $text
 * @property string|null $hidden_name
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Modules\Products\Models\Product $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductTranslates whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductTranslates whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductTranslates whereHiddenName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductTranslates whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductTranslates whereSeoText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductTranslates whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductTranslates whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductTranslates whereTitle($value)
 * @mixin \Eloquent
 */
class ProductTranslates extends Model
{
    use ModelTranslates;
    
    protected $table = 'products_translates';
    
    public $timestamps = false;
    
    protected $fillable = ['name', 'slug', 'h1', 'title', 'description', 'keywords', 'seo_text', 'text', 'row_id', 'language', 'hidden_name'];
    
    /**
     * @param string $lang
     * @param array $data
     * @param int $productId
     * @param ProductGroup $group
     * @param FeatureValue $value
     * @return ProductTranslates|null
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function createOrUpdateFromArray(string $lang, array $data, ?int $productId, ProductGroup $group, FeatureValue $value): ?ProductTranslates
    {
        $data['name'] = array_get($data, 'name') ?: '';
        $parts = [];
        if ($group->brand) {
            $parts[] = $group->brand->dataFor($lang)->name ?? '';
        }
        $parts[] = $group->dataFor($lang)->name;
        if ($value) {
            $parts[] = $value->dataFor($lang)->name ?? '';
        }
        $data['hidden_name'] = implode(' ', $parts);
        $data['slug'] = array_get($data, 'slug') ?: Str::slug($data['name'] ?: $data['hidden_name']);
        if (Validator::make($data, ['slug' => new MultilangSlug((new ProductTranslates)->getTable(), $lang, $productId)])->fails()) {
            $data['slug'] .= '-' . Str::random(8);
        }
        return ProductTranslates::updateOrCreate([
            'row_id' => $productId,
            'language' => $lang,
        ], $data);
    }
}
