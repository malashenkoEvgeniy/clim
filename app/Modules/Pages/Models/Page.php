<?php

namespace App\Modules\Pages\Models;

use App\Traits\ModelMain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

/**
 * App\Modules\Pages\Models\Page
 *
 * @property int $id
 * @property bool $active
 * @property int $position
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $menu
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Pages\Models\Page[] $children
 * @property-read \App\Modules\Pages\Models\PageTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Pages\Models\PageTranslates[] $data
 * @property-read \App\Modules\Pages\Models\Page $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\Page published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\Page topLevel()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\Page whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\Page whereMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\Page whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\Page wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Pages\Models\Page whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Page extends Model
{
    use ModelMain;
    
    protected $casts = ['active' => 'boolean'];
    
    protected $fillable = ['active', 'parent_id','menu'];
    
    /**
     * If parent_id is nullable then we should set 0
     *
     * @param $value
     */
    public function setParentIdAttribute($value)
    {
        $this->attributes['parent_id'] = (int)$value;
    }
    
    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('active', '=', true);
    }
    
    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTopLevel($query)
    {
        return $query->where('parent_id', '=', 0);
    }
    
    /**
     * Parent page
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id')->with(['current']);
    }
    
    /**
     * Get kids for current page
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->with(['current', 'children']);
    }
    
    /**
     * @param  null|integer $parentId
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public static function getList($parentId = null)
    {
        $pages = Page::with(['current', 'children']);
        if ($parentId !== null) {
            $pages->whereParentId($parentId);
            if ($parentId === 0) {
                $pages->orWhere('parent_id', null);
            }
        }
        return $pages->oldest('position')->get();
    }
    
    /**
     * Get array for select
     *
     * @param  int $parentId
     * @return array
     */
    public function getSelectArray($parentId = 0)
    {
        return $this->getList($parentId)->map(
            function (Page $page) {
                return [
                    'id' => $page->id,
                    'name' => $page->current->name,
                    'children' => $page->getSelectArray($page->id),
                ];
            }
        )->toArray();
    }
    
    /**
     * Generate dropdown list
     *
     * @return array
     */
    public function generateDropDownArray()
    {
        $select = $this->getSelectArray();
        return $this->recursive($select);
    }
    
    /**
     * Recursively generate data to show in select
     *
     * @param  array $select
     * @param  string $level
     * @return array
     */
    private function recursive(array $select, $level = '')
    {
        $array = [];
        foreach ($select AS $option) {
            if ($option['id'] != $this->id) {
                $array[$option['id']] = $level . $option['name'];
                if (array_get($option, 'children', [])) {
                    $children = $this->recursive($option['children'], $level . '&nbsp;&nbsp;&nbsp;&nbsp;');
                    foreach ($children AS $childId => $childName) {
                        $array[$childId] = $childName;
                    }
                }
            }
        }
        return $array;
    }
    
    /**
     * Set parent_id to kids for current page as parent_id of current page
     */
    public function setOtherParentIdForKids()
    {
        Page::where('parent_id', '=', $this->id)->update(
            [
                'parent_id' => $this->parent_id,
            ]
        );
    }
    
    public static function getMenuAtPage(int $menu)
    {
        return Page::whereMenu($menu)->published()->oldest('position')->get();
    }
}
