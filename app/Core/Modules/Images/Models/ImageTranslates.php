<?php

namespace App\Core\Modules\Images\Models;

use App\Core\Modules\Languages\Models\Language;
use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Modules\Images\Models\ImageTranslates
 *
 * @property int $id
 * @property string|null $alt
 * @property string|null $title
 * @property int $row_id
 * @property string $language
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Core\Modules\Images\Models\Image $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\ImageTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\ImageTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\ImageTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\ImageTranslates whereAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\ImageTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\ImageTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\ImageTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\ImageTranslates whereTitle($value)
 * @mixin \Eloquent
 */
class ImageTranslates extends Model
{
    use ModelTranslates;
    
    protected $table = 'images_translates';
    
    protected $fillable = ['alt', 'title'];
    
    public $timestamps = false;
    
    public static function createEmpty(Image $image, Language $language): bool
    {
        $translate = new ImageTranslates();
        $translate->language = $language->slug;
        $translate->row_id = $image->id;
        return $translate->save();
    }
}