<?php

namespace App\Modules\Pages\Models;

use App\Rules\MultilangSlug;
use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

/**
 * App\Modules\Pages\Models\PageTranslates
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
 * @property-read \App\Modules\Pages\Models\Page $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\PageTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\PageTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\PageTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\PageTranslates whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\PageTranslates whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\PageTranslates whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\PageTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\PageTranslates whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\PageTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\PageTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\PageTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\PageTranslates whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\PageTranslates whereTitle($value)
 * @mixin \Eloquent
 */
class PageTranslates extends Model
{
    use ModelTranslates;
    
    protected $table = 'pages_translates';
    
    public $timestamps = false;
    
    protected $fillable = ['slug', 'name', 'content', 'h1', 'title', 'keywords', 'description'];
    
}
