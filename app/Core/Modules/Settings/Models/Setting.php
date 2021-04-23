<?php

namespace App\Components\Settings\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Components\Settings\Models\Setting
 *
 * @property int $id
 * @property string $group
 * @property string $alias
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Components\Settings\Models\Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Components\Settings\Models\Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Components\Settings\Models\Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Components\Settings\Models\Setting whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Components\Settings\Models\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Components\Settings\Models\Setting whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Components\Settings\Models\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Components\Settings\Models\Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Components\Settings\Models\Setting whereValue($value)
 * @mixin \Eloquent
 */
class Setting extends Model
{
    
    protected $fillable = ['value', 'group', 'alias'];
    
}
