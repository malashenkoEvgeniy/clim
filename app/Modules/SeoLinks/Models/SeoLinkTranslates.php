<?php

namespace App\Modules\SeoLinks\Models;

use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\SeoLinks\Models\SeoLinkTranslates
 *
 * @property int $id
 * @property string $name
 * @property string|null $h1
 * @property string|null $title
 * @property string|null $keywords
 * @property string|null $description
 * @property int $row_id
 * @property string $language
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Modules\SeoLinks\Models\SeoLink $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLinkTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLinkTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLinkTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLinkTranslates whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLinkTranslates whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLinkTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLinkTranslates whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLinkTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLinkTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLinkTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLinkTranslates whereTitle($value)
 * @mixin \Eloquent
 */
class SeoLinkTranslates extends Model
{
    use ModelTranslates;

    protected $table = 'seo_links_translates';

    public $timestamps = false;

    protected $fillable = ['name', 'h1', 'title', 'keywords', 'description'];
}
