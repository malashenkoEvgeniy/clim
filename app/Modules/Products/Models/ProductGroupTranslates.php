<?php

namespace App\Modules\Products\Models;

use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Products\Models\ProductGroupTranslates
 *
 * @property int $id
 * @property int $row_id
 * @property string $language
 * @property string $name
 * @property string|null $text
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Modules\Products\Models\ProductGroup $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupTranslates whereText($value)
 * @mixin \Eloquent
 * @property string|null $text_related
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupTranslates whereTextRelated($value)
 */
class ProductGroupTranslates extends Model
{
    use ModelTranslates;
    
    protected $table = 'products_groups_translates';
    
    public $timestamps = false;
    
    protected $fillable = ['name', 'text', 'text_related'];
}
