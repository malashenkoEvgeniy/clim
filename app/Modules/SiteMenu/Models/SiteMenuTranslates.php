<?php

namespace App\Modules\SiteMenu\Models;

use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\SiteMenu\Models\SiteMenuTranslates
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $slug_type
 * @property string $language
 * @property int $row_id
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Modules\SiteMenu\Models\SiteMenu $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenuTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenuTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenuTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenuTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenuTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenuTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenuTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenuTranslates whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenuTranslates whereSlugType($value)
 * @mixin \Eloquent
 */
class SiteMenuTranslates extends Model
{
    use ModelTranslates;
    
    protected $table = 'site_menu_translates';
    
    public $timestamps = false;
    
    protected $fillable = ['name', 'slug', 'slug_type'];
    
}