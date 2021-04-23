<?php

namespace App\Modules\Categories\Models;

use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Categories\Models\CategoryTranslates
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
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Modules\Categories\Models\Category $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\CategoryTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\CategoryTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\CategoryTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\CategoryTranslates whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\CategoryTranslates whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\CategoryTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\CategoryTranslates whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\CategoryTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\CategoryTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\CategoryTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\CategoryTranslates whereSeoText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\CategoryTranslates whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\CategoryTranslates whereTitle($value)
 * @mixin \Eloquent
 */
class CategoryTranslates extends Model
{
    use ModelTranslates;

    protected $table = 'categories_translates';
    
    public $timestamps = false;
    
    protected $fillable = ['name', 'slug', 'h1', 'title', 'keywords', 'description', 'seo_text'];
}
