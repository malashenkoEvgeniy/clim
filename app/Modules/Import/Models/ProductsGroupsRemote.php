<?php

namespace App\Modules\Import\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsRemote
 *
 * @property int $id
 * @property int|null $group_id
 * @property int $remote_id
 * @property null|string $system
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\ProductsGroupsRemote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\ProductsGroupsRemote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\ProductsGroupsRemote query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\ProductsGroupsRemote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\ProductsGroupsRemote whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\ProductsGroupsRemote whereRemoteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\ProductsGroupsRemote whereSystem($value)
 * @mixin \Eloquent
 */
class ProductsGroupsRemote extends Model
{
    
    protected $table = 'products_groups_remote';
    
    public $timestamps = false;
    
    protected $fillable = ['group_id', 'remote_id', 'system'];
    
}
