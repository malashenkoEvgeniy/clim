<?php

namespace App\Modules\LabelsForProducts\Models;

use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\LabelsForProducts\Models\LabelTranslates
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $text
 * @property int $row_id
 * @property string $language
 * @property string|null $h1
 * @property string|null $title
 * @property string|null $keywords
 * @property string|null $description
 * @property string|null $content
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Modules\LabelsForProducts\Models\Label $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\LabelTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\LabelTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\LabelTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\LabelTranslates whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\LabelTranslates whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\LabelTranslates whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\LabelTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\LabelTranslates whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\LabelTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\LabelTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\LabelTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\LabelTranslates whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\LabelTranslates whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\LabelTranslates whereTitle($value)
 * @mixin \Eloquent
 */
class LabelTranslates extends Model
{
    use ModelTranslates;
    
    protected $table = 'labels_translates';
    
    protected $fillable = ['name', 'slug', 'text', 'h1', 'title', 'description', 'keywords', 'content'];
    
    public $timestamps = false;
    
}
