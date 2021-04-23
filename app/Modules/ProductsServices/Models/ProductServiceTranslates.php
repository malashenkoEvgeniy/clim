<?php

namespace App\Modules\ProductsServices\Models;

use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\ProductsServices\Models\ProductServiceTranslates
 *
 * @property int $id
 * @property int $row_id
 * @property string $language
 * @property string $name
 * @property string|null $description
 * @property string|null $text
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Modules\ProductsServices\Models\ProductService $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductServiceTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductServiceTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductServiceTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductServiceTranslates whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductServiceTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductServiceTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductServiceTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductServiceTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductServiceTranslates whereText($value)
 * @mixin \Eloquent
 */
class ProductServiceTranslates extends Model
{
    use ModelTranslates;
    
    protected $table = 'products_services_translates';
    
    public $timestamps = false;
    
    protected $fillable = ['name', 'description', 'text', 'row_id', 'language'];
}
