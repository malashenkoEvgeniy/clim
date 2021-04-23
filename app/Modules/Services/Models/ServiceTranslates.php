<?php

namespace App\Modules\Services\Models;

use App\Rules\MultilangSlug;
use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

/**
 * App\Modules\Pages\Models\ServiceTranslates
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
 * @property-read \App\Modules\Services\Models\Service $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServiceTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServiceTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServiceTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServiceTranslates whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServiceTranslates whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServiceTranslates whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServiceTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServiceTranslates whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServiceTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServiceTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServiceTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServiceTranslates whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServiceTranslates whereTitle($value)
 * @mixin \Eloquent
 */
class ServiceTranslates extends Model
{
    use ModelTranslates;

    protected $table = 'services_translates';

    public $timestamps = false;

    protected $fillable = ['slug', 'name', 'content', 'h1', 'title', 'keywords', 'description'];

}
