<?php

namespace App\Modules\ProductsDictionary\Models;

use App\Traits\ActiveScopeTrait;
use App\Traits\CheckRelation;
use Greabock\Tentacles\EloquentTentacle;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\ProductsDictionary\Models\Dictionary
 *
 * @property int $id
 * @property int $group_id
 * @property int $dictionary_id
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\ProductsDictionary\Models\Dictionary $dictionary
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary active($active = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\Dictionary whereDictionaryId($value)
 * @mixin \Eloquent
 */
class DictionaryRelation extends Model
{
    use ActiveScopeTrait, EloquentTentacle, CheckRelation;
    
    protected $table = 'products_dictionary_related';

    protected $fillable = ['group_id', 'dictionary_id'];

    public function dictionary()
    {
        return $this->belongsTo(Dictionary::class, 'dictionary_id', 'id');
    }
}
