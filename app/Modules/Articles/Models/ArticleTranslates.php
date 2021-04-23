<?php

namespace App\Modules\Articles\Models;

use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Modules\Articles\Models\ArticleTranslates
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
 * @property-read \App\Modules\Articles\Models\Article $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\ArticleTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\ArticleTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\ArticleTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\ArticleTranslates whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\ArticleTranslates whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\ArticleTranslates whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\ArticleTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\ArticleTranslates whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\ArticleTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\ArticleTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\ArticleTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\ArticleTranslates whereShortContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\ArticleTranslates whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\ArticleTranslates whereTitle($value)
 * @mixin \Eloquent
 */
class ArticleTranslates extends Model
{
    use ModelTranslates;
    
    protected $table = 'articles_translates';
    
    public $timestamps = false;
    
    protected $fillable = ['slug', 'name', 'short_content', 'content', 'h1', 'title', 'keywords', 'description'];
    
}
