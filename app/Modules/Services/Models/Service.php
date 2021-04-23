<?php

namespace App\Modules\Services\Models;

use App\Traits\ModelMain;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Services\Images\ServicesImage;
use App\Traits\Imageable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use App\Traits\ActiveScopeTrait;

class Service extends Model
{
    use ModelMain, Imageable, ActiveScopeTrait;

    protected $casts = ['active' => 'boolean'];

    protected $fillable = ['active', 'parent_id', 'rubric_id', 'sub_rubric'];

    public static $dump;

    /**
     * App\Modules\Services\Models\ServiceRubric
     *
     * @property int $id
     * @property bool $active
     * @property int $parent_id
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property int|null $menu
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Pages\Models\Page[] $children
     * @property-read \App\Modules\Pages\Models\ServiceTranslates $current
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Pages\Models\ServiceTranslates[] $data
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\Service newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\Service newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\Service published()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\Service query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\Service topLevel()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\Service whereActive($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\Service whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\Service whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\Service whereMenu($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\Service whereParentId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\Service wherePosition($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\Service whereUpdatedAt($value)
     * @mixin \Eloquent
     */

    public function category()
    {
        return $this->belongsTo(ServicesRubric::class, 'rubric_id')->with('translations');
    }

    public static function getList()
    {
        $rubrics = Service::with(['current', 'image', 'image.current', 'category']);
        return $rubrics->oldest('position')->get();
    }



    /**
     * Link on the show service inner page
     *
     * @return string
     */
    public function getLinkAttribute(): string
    {
        return route('site.service', [
            'url' => $this->current->slug,
        ]);
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

    public static function getByParent($parent_id)
    {
       return Service::with('current')
            ->where('parent_id', '=', $parent_id)
            ->get();
    }

    /**
     * Image config
     *
     * @return string|array
     */
    protected function imageClass()
    {
        return ServicesImage::class;
    }


    /**
     * @param int $id
     * @return array|null
     */
    public function getPagesLinksByIdForImage(int $id)
    {
        $links = [];
        $item = Service::active()->find($id);
        if($item){
            if($item->parent){
                $links[] = url(route('site.services', ['slug' => $item->parent->current->slug], false), [], isSecure());
            } else {
                $links[] = url(route('site.services', [], false), [], isSecure());
            }

        }
        return $links;
    }



    public static function dump(): void
    {
        if (static::$dump !== null) {
            return;
        }

        static::$dump = new EloquentCollection();

        if (\Schema::hasTable('services') === false) {
            return;
        }

        Service::with(
            'current',
            'image', 'image.current'
        )
            ->active()
            ->oldest('position')
            ->latest('id')
            ->get()
            ->each(function (Service $service) {
                static::$dump->put($service->id, $service);
            });
    }

    public static function getOneBySlug(string $slug): ?Service
    {
        static::dump();
        foreach (static::$dump as $service) {
            if ($service->current->slug === $slug) {
                return $service;
            }
        }
        return null;
    }

}