<?php

namespace App\Modules\Services\Models;

use App\Rules\MultilangSlug;
use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

/**
 * App\Modules\Pages\Models\ServicesRubricsTranslates
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
 * @property-read \App\Modules\Services\Models\ServicesRubric $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubricTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubricTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubricTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubricTranslates whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubricTranslates whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubricTranslates whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubricTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubricTranslates whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubricTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubricTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubricTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubricTranslates whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubricTranslates whereTitle($value)
 * @mixin \Eloquent
 */
class ServicesRubricTranslates extends Model
{
    use ModelTranslates;
    
    protected $table = 'services_rubrics_translates';
    
    public $timestamps = false;
    
    protected $fillable = ['slug', 'name', 'content', 'h1', 'title', 'keywords', 'description'];
    
}
