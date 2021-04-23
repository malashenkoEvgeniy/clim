<?php

namespace App\Modules\ProductsDictionary\Models;

use App\Components\Settings\Models\Setting;
use App\Traits\ActiveScopeTrait;
use App\Traits\CheckRelation;
use App\Traits\ModelMain;
use Greabock\Tentacles\EloquentTentacle;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\ProductsDictionary\Models\Dictionary
 *
 * @property int $id
 * @property int $position
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\ProductsDictionary\Models\DictionaryTranslates $current
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary active($active = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\ProductsDictionary\Models\DictionaryTranslates[] $data
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\ProductsDictionary\Models\DictionaryRelation[] $relations
 */
class Dictionary extends Model
{
    use ModelMain, ActiveScopeTrait, EloquentTentacle, CheckRelation;

    protected $table = 'products_dictionary';

    protected $casts = ['active' => 'boolean', 'position' => 'integer'];

    protected $fillable = ['position', 'active'];

    public function getName()
    {
        $setting = Setting::whereGroup('products_dictionary')->whereAlias(\Lang::getLocale() . '_title')->first();

        return $setting->value;
    }
    
    public function relations()
    {
        return $this->hasMany(DictionaryRelation::class, 'dictionary_id', 'id');
    }

}
