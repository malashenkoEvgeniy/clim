<?php

namespace App\Modules\Features\Models;

use App\Traits\ActiveScopeTrait;
use App\Traits\CheckRelation;
use App\Traits\ModelMain;
use Greabock\Tentacles\EloquentTentacle;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Features\Models\FeatureValue
 *
 * @property int $id
 * @property int $position
 * @property bool $active
 * @property int|null $feature_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Features\Models\FeatureValueTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Features\Models\FeatureValueTranslates[] $data
 * @property-read \App\Modules\Features\Models\Feature|null $feature
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValue active($active = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValue whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValue whereFeatureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValue wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\FeatureValue whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FeatureValue extends Model
{
    use ModelMain, ActiveScopeTrait, EloquentTentacle, CheckRelation;
    
    protected $table = 'features_values';
    
    protected $casts = ['active' => 'boolean', 'position' => 'integer'];
    
    protected $fillable = ['position', 'feature_id', 'active'];
    
    public function feature()
    {
        return $this->belongsTo(Feature::class, 'feature_id', 'id');
    }
}
