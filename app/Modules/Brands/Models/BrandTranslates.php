<?php

namespace App\Modules\Brands\Models;

use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Lang;

/**
 * App\Modules\Brands\Models\BrandTranslates
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $content
 * @property string|null $h1
 * @property string|null $title
 * @property string|null $keywords
 * @property string|null $description
 * @property int $row_id
 * @property string $language
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Modules\Brands\Models\Brand $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\BrandTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\BrandTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\BrandTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\BrandTranslates whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\BrandTranslates whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\BrandTranslates whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\BrandTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\BrandTranslates whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\BrandTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\BrandTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\BrandTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\BrandTranslates whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\BrandTranslates whereTitle($value)
 * @mixin \Eloquent
 */
class BrandTranslates extends Model
{
    use ModelTranslates;
    
    protected $table = 'brands_translates';
    
    public $timestamps = false;
    
    protected $fillable = ['slug', 'name', 'content', 'h1', 'title', 'keywords', 'description'];
    
    public static function allActiveForFilter()
    {
        return BrandTranslates::whereLanguage(Lang::getLocale())
            ->whereHas('row', function (Builder $builder) {
                $builder->where('active', true);
            });
    }
    
}
