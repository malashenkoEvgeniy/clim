<?php

namespace App\Modules\SeoTemplates\Models;

use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\SeoTemplates\Models\SeoTemplateTranslates
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
 * @property-read \App\Modules\SeoTemplates\Models\SeoTemplate $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplateTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplateTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplateTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplateTranslates whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplateTranslates whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplateTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplateTranslates whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplateTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplateTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplateTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplateTranslates whereTitle($value)
 * @mixin \Eloquent
 */
class SeoTemplateTranslates extends Model
{
    use ModelTranslates;

    protected $table = 'seo_template_translates';

    public $timestamps = false;

    protected $fillable = ['name', 'h1', 'title', 'keywords', 'description'];
}
