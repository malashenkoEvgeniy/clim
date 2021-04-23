<?php

namespace App\Modules\Features\Models;

use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Features\Models\FeatureValueTranslates
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $row_id
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Modules\Features\Models\FeatureValue $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValueTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValueTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValueTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValueTranslates whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValueTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValueTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValueTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValueTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValueTranslates whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValueTranslates whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class FeatureValueTranslates extends Model
{
    use ModelTranslates;
    
    protected $table = 'features_values_translates';
    
    protected $fillable = ['name', 'slug'];
}

