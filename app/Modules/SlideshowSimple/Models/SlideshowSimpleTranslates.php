<?php

namespace App\Modules\SlideshowSimple\Models;

use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\SlideshowSimple\Models\SlideshowSimpleTranslates
 *
 * @property int $id
 * @property string $name
 * @property int $row_id
 * @property string $language
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Modules\SlideshowSimple\Models\SlideshowSimple $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SlideshowSimple\Models\SlideshowSimpleTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SlideshowSimple\Models\SlideshowSimpleTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SlideshowSimple\Models\SlideshowSimpleTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SlideshowSimple\Models\SlideshowSimpleTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SlideshowSimple\Models\SlideshowSimpleTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SlideshowSimple\Models\SlideshowSimpleTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SlideshowSimple\Models\SlideshowSimpleTranslates whereRowId($value)
 * @mixin \Eloquent
 */
class SlideshowSimpleTranslates extends Model
{
    use ModelTranslates;
    
    protected $table = 'slideshow_simple_translates';
    
    public $timestamps = false;
    
    protected $fillable = ['name'];
    
}
