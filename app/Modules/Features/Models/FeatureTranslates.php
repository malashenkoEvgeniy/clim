<?php

namespace App\Modules\Features\Models;

use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Features\Models\FeatureTranslates
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $row_id
 * @property string $language
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Modules\Features\Models\Feature $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureTranslates whereSlug($value)
 * @mixin \Eloquent
 */
class FeatureTranslates extends Model
{
    use ModelTranslates;
    
    protected $table = 'features_translates';
    
    public $timestamps = false;
    
    protected $fillable = ['name', 'slug'];
}
