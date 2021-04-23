<?php

namespace App\Modules\SiteMenu\Models;

use App\Traits\ActiveScopeTrait;
use App\Traits\ModelMain;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Route;

/**
 * App\Modules\SiteMenu\Models\SiteMenu
 *
 * @property int $id
 * @property bool $active
 * @property int $noindex
 * @property int $nofollow
 * @property string $place
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $parent_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SiteMenu\Models\SiteMenu[] $children
 * @property-read \App\Modules\SiteMenu\Models\SiteMenuTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SiteMenu\Models\SiteMenuTranslates[] $data
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenu active($active = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenu whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenu whereNofollow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenu whereNoindex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenu wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenu wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SiteMenu\Models\SiteMenu whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SiteMenu extends Model
{
    use ModelMain, ActiveScopeTrait;

    const PLACE_FOOTER = 'footer';
    const PLACE_HEADER = 'header';
    const PLACE_MOBILE = 'mobile';

    protected $table = 'site_menu';
    
    protected $casts = ['active' => 'boolean'];
    
    protected $fillable = ['active', 'place', 'noindex', 'nofollow', 'parent_id'];
    
    const EXTERNAL_LINK = 'external';
    const INTERNAL_LINK = 'internal';
    
    /**
     * Get list of menu items
     *
     * @return SiteMenu[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function getList()
    {
        $siteMenus = static::with(['current'])
            ->wherePlace(Route::current()->parameter('place'));
        return $siteMenus->oldest('position')->get();
    }
    
    public static function activeOnly()
    {
        return SiteMenu::with('current')->active(true)->oldest('position')->get();
    }

    public function children()
    {
        return $this->hasMany(SiteMenu::class, 'parent_id', 'id')
            ->with(['current', 'children'])
            ->oldest('position')
            ->oldest('id');
    }

    /**
     * Builds categories full tree
     *
     * @param string $place
     * @return Collection|SiteMenu[][]
     */
    public static function tree(string $place): Collection
    {
        $tree = new Collection();
        SiteMenu::with('current')
            ->wherePlace($place)
            ->oldest('position')
            ->oldest('id')
            ->get()
            ->each(function (SiteMenu $menu) use (&$tree) {
                $elements = $tree->get((int)$menu->parent_id, []);
                $elements[] = $menu;
                $tree->put((int)$menu->parent_id, $elements);
            });
        return $tree;
    }

    /**
     * @param string $place
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function topLevel(string $place): \Illuminate\Database\Eloquent\Collection
    {
        return SiteMenu::with(['current'])
            ->wherePlace($place)
            ->where(function (Builder $query) {
                $query
                    ->whereNull('parent_id')
                    ->orWhere('parent_id', 0);
            })
            ->oldest('position')
            ->get();
    }

    public static function topLevelForSelect(string $place): array
    {
        $elements = [];
        SiteMenu::topLevel($place)->each(function (SiteMenu $siteMenu) use (&$elements) {
            $elements[$siteMenu->id] = $siteMenu->current->name ?? 'Unknown';
        });
        return $elements;
    }
}
