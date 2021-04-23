<?php

namespace App\Modules\News\Models;

use App\Rules\MultilangSlug;
use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;


/**
 * App\Modules\News\Models\NewsTranslates
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $short_content
 * @property string|null $content
 * @property string|null $h1
 * @property string|null $title
 * @property string|null $keywords
 * @property string|null $description
 * @property int $row_id
 * @property string $language
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Modules\News\Models\News $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\NewsTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\NewsTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\NewsTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\NewsTranslates whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\NewsTranslates whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\NewsTranslates whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\NewsTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\NewsTranslates whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\NewsTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\NewsTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\NewsTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\NewsTranslates whereShortContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\NewsTranslates whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\NewsTranslates whereTitle($value)
 * @mixin \Eloquent
 */
class NewsTranslates extends Model
{
    use ModelTranslates;
    
    protected $table = 'news_translates';
    
    public $timestamps = false;
    
    protected $fillable = ['slug', 'name', 'short_content', 'content', 'h1', 'title', 'keywords', 'description'];
    
}
