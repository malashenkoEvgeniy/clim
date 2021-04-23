<?php

namespace App\Modules\SeoScripts\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\SeoScripts\Models\SeoScript
 *
 * @property int $id
 * @property bool $active
 * @property string $name
 * @property string $place
 * @property string $script
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoScripts\Models\SeoScript newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoScripts\Models\SeoScript newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoScripts\Models\SeoScript query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoScripts\Models\SeoScript whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoScripts\Models\SeoScript whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoScripts\Models\SeoScript whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoScripts\Models\SeoScript whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoScripts\Models\SeoScript wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoScripts\Models\SeoScript whereScript($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoScripts\Models\SeoScript whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SeoScript extends Model
{
    protected $casts = ['active' => 'boolean'];

    protected $fillable = ['name', 'script', 'active', 'place'];

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getList()
    {
        return SeoScript::oldest('id')->get();
    }
}
