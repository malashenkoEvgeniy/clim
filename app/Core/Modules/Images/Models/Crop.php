<?php

namespace App\Core\Modules\Images\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Modules\Images\Models\Crop
 *
 * @property int $id
 * @property string $x
 * @property string $y
 * @property string $width
 * @property string $height
 * @property int $model_id
 * @property string $model_name
 * @property string $size
 * @property string|null $folder
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Crop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Crop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Crop query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Crop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Crop whereFolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Crop whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Crop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Crop whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Crop whereModelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Crop whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Crop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Crop whereWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Crop whereX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Images\Models\Crop whereY($value)
 * @mixin \Eloquent
 */
class Crop extends Model
{
    protected $table = 'crop';
    
    protected $fillable = ['x', 'y', 'width', 'height'];
}
