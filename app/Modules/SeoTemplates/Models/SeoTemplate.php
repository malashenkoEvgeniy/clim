<?php

namespace App\Modules\SeoTemplates\Models;

use App\Traits\ModelMain;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\SeoTemplates\Models\SeoTemplate
 *
 * @property int $id
 * @property array|null $variables
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $alias
 * @property-read \App\Modules\SeoTemplates\Models\SeoTemplateTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SeoTemplates\Models\SeoTemplateTranslates[] $data
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplate whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoTemplates\Models\SeoTemplate whereVariables($value)
 * @mixin \Eloquent
 */
class SeoTemplate extends Model
{
    use ModelMain;

    protected $fillable = ['updated_at'];

    protected $casts = [
        'variables' => 'array',
    ];

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getList()
    {
        return SeoTemplate::oldest('id')->get();
    }
}
