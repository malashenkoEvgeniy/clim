<?php

namespace App\Modules\Import\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoriesRemote
 *
 * @property int $id
 * @property int|null $category_id
 * @property int $remote_id
 * @property null|string $system
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\CategoriesRemote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\CategoriesRemote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\CategoriesRemote query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\CategoriesRemote whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\CategoriesRemote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\CategoriesRemote whereRemoteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\CategoriesRemote whereSystem($value)
 * @mixin \Eloquent
 */
class CategoriesRemote extends Model
{
    
    protected $table = 'categories_remote';
    
    public $timestamps = false;
    
    protected $fillable = ['category_id', 'remote_id', 'system'];
    
}
