<?php

namespace App\Modules\ProductsDictionary\Models;

use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\ProductsDictionary\Models\DictionaryTranslates
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $row_id
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Modules\ProductsDictionary\Models\Dictionary $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\DictionaryTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\DictionaryTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\DictionaryTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\DictionaryTranslates whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\DictionaryTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\DictionaryTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\DictionaryTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\DictionaryTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\DictionaryTranslates whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsDictionary\Models\DictionaryTranslates whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class DictionaryTranslates extends Model
{
    use ModelTranslates;
    
    protected $table = 'products_dictionary_translates';
    
    protected $fillable = ['name', 'slug'];
}

