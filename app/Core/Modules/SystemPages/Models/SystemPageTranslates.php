<?php

namespace App\Core\Modules\SystemPages\Models;

use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Modules\SystemPages\Models\SystemPageTranslates
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $content
 * @property string|null $h1
 * @property string|null $title
 * @property string|null $keywords
 * @property string|null $description
 * @property string $language
 * @property int $row_id
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Core\Modules\SystemPages\Models\SystemPage $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPageTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPageTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPageTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPageTranslates whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPageTranslates whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPageTranslates whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPageTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPageTranslates whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPageTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPageTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPageTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPageTranslates whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPageTranslates whereTitle($value)
 * @mixin \Eloquent
 */
class SystemPageTranslates extends Model
{
    use ModelTranslates;
    
    protected $table = 'system_pages_translates';
    
    public $timestamps = false;
    
    protected $fillable = ['name', 'content', 'h1', 'title', 'keywords', 'description'];
}
