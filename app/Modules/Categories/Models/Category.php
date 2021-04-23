<?php

namespace App\Modules\Categories\Models;

use App\Modules\Categories\Images\CategoryImage;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductGroup;
use App\Traits\ActiveScopeTrait;
use App\Traits\CheckRelation;
use App\Traits\Imageable;
use App\Traits\ModelMain;
use Greabock\Tentacles\EloquentTentacle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

/**
 * App\Modules\Categories\Models\Category
 *
 * @property int $id
 * @property bool $active
 * @property int|null $parent_id
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read EloquentCollection|\App\Modules\Categories\Models\Category[] $activeChildren
 * @property-read EloquentCollection|\App\Core\Modules\Images\Models\Image[] $allImages
 * @property-read EloquentCollection|\App\Modules\Categories\Models\Category[] $children
 * @property-read \App\Modules\Categories\Models\CategoryTranslates $current
 * @property-read EloquentCollection|\App\Modules\Categories\Models\CategoryTranslates[] $data
 * @property-read bool $has_children
 * @property-read bool $has_active_children
 * @property-read string $link_in_admin_panel
 * @property-read string $site_link
 * @property-read \App\Core\Modules\Images\Models\Image $image
 * @property-read EloquentCollection|\App\Core\Modules\Images\Models\Image[] $images
 * @property-read \App\Modules\Categories\Models\Category $parent
 * @property-read EloquentCollection|\App\Modules\Products\Models\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\Category active($active = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\Category whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\Category wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Categories\Models\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use ModelMain, Imageable, EloquentTentacle, ActiveScopeTrait, CheckRelation;

    const SEO_TEMPLATE_ALIAS = 'categories';
    
    protected $casts = ['active' => 'boolean'];
    
    protected $fillable = ['active', 'image', 'parent_id'];
    
    /**
     * @var null|Category[][]|EloquentCollection
     */
    public static $dumpParent;
    
    /**
     * @var null|Category[]|EloquentCollection
     */
    public static $dump;
    
    public static function dump(): void
    {
        if (static::$dump !== null) {
            return;
        }
        static::$dump = new EloquentCollection();
        static::$dumpParent = new EloquentCollection();
        if (\Schema::hasTable('categories') === false) {
            return;
        }
        Category::with(
            'current',
            'image', 'image.current',
            'activeChildren'
        )
            ->active()
            ->oldest('position')
            ->latest('id')
            ->get()
            ->each(function (Category $category) {
                $currentCollection = static::$dumpParent->get((int)$category->parent_id, new EloquentCollection());
                $currentCollection->push($category);
                static::$dumpParent->put((int)$category->parent_id, $currentCollection);
                static::$dump->put($category->id, $category);
            });
    }
    
    /**
     * @return array
     */
    public static function getDictionaryForSelects(): array
    {
        $categories = new EloquentCollection();
        Category::with('current')
            ->oldest('position')
            ->latest('id')
            ->get()
            ->each(function (Category $category) use ($categories) {
                $currentCollection = $categories->get((int)$category->parent_id, new EloquentCollection());
                $currentCollection->push($category);
                $categories->put((int)$category->parent_id, $currentCollection);
            });
        return static::makeDictionaryFrom($categories, 0);
    }
    
    /**
     * @param EloquentCollection $categories
     * @param int $parentId
     * @param array $dictionary
     * @param int $level
     * @return array
     */
    protected static function makeDictionaryFrom(EloquentCollection $categories, int $parentId, array &$dictionary = [], int $level = 0): array
    {
        $categories->get($parentId, new EloquentCollection)->each(function (Category $category) use (&$dictionary, $level, $categories) {
            $spaces = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
            $dictionary[$category->id] = $spaces . $category->current->name;
            static::makeDictionaryFrom($categories, $category->id, $dictionary, ++$level);
        });
        return $dictionary;
    }
    
    /**
     * @param int $categoryId
     * @return Category|null
     */
    public static function getOne(?int $categoryId): ?Category
    {
        static::dump();
        return static::$dump->get($categoryId);
    }
    
    /**
     * @param string $slug
     * @return Category|null
     */
    public static function getOneBySlug(string $slug): ?Category
    {
        static::dump();
        foreach (static::$dump as $category) {
            if ($category->current->slug === $slug) {
                return $category;
            }
        }
        return null;
    }
    
    /**
     * @param int $categoryId
     * @return EloquentCollection|Category[]
     */
    public static function getKidsFor(?int $categoryId): EloquentCollection
    {
        static::dump();
        return static::$dumpParent->get((int)$categoryId, new EloquentCollection);
    }
    
    /**
     * @return EloquentCollection|Category[]
     */
    public function getKids(): EloquentCollection
    {
        static::dump();
        return static::$dumpParent->get($this->id, new EloquentCollection);
    }
    
    /**
     * @return EloquentCollection|Category[]
     */
    public function getSame(): EloquentCollection
    {
        static::dump();
        return static::getKidsFor((int)$this->parent_id)->filter(function (Category $category) {
            return $category->id !== $this->id;
        });
    }
    
    /**
     * @return EloquentCollection|Category[]
     */
    public function getKidsOrSameIfEmpty(): EloquentCollection
    {
        static::dump();
        $kids = static::getKidsFor((int)$this->id);
        return $kids->isNotEmpty() ? $kids : static::getKidsFor((int)$this->parent_id);
    }
    
    /**
     * @return Category|null
     */
    public function getParent(): ?Category
    {
        static::dump();
        return $this->getOne((int)$this->parent_id);
    }
    
    /**
     * Image config
     *
     * @return string|array
     */
    protected function imageClass()
    {
        return CategoryImage::class;
    }
    
    /**
     * Get categories list related to this group
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')
            ->with(['current', 'children'])
            ->oldest('position')
            ->latest('id');
    }
    
    /**
     * Get categories list related to this group
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activeChildren()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')
            ->where('active', true)
            ->with(['current', 'activeChildren'])
            ->oldest('position')
            ->latest('id');
    }
    
    /**
     * Parent category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            ProductGroup::class,
            'category_id',
            'group_id',
            'id',
            'id'
        );
    }
    
    /**
     * Checks if parent can be linked as parent for chosen category
     *
     * @param int $categoryId
     * @param int|null $parentId
     * @return bool
     */
    public static function isAvailableToChoose(int $categoryId, ?int $parentId = null): bool
    {
        if ($parentId === null) {
            return true;
        }
        if ($categoryId === $parentId) {
            return false;
        }
        return in_array($parentId, Category::getAllChildrenIds($categoryId)) === false;
    }
    
    /**
     * Builds categories full tree
     *
     * @return Collection|Category[][]
     */
    public static function tree(): Collection
    {
        $categories = new Collection();
        Category::with('current')
            ->oldest('position')
            ->latest('id')
            ->get()
            ->each(function (Category $category) use ($categories) {
                $elements = $categories->get((int)$category->parent_id, []);
                $elements[] = $category;
                $categories->put((int)$category->parent_id, $elements);
            });
        return $categories;
    }
    
    /**
     * Get Parent ids for category by slug
     *
     * @param string $slug
     * @return EloquentCollection
     */
    public static function getTreeFilter(string $slug): EloquentCollection
    {
        $categories = new EloquentCollection();
        static::dump();
        $category = null;
        foreach (static::$dump as $categoryObject) {
            if ($categoryObject->current->slug === $slug) {
                $category = $categoryObject;
                break;
            }
        }
        if (!$category) {
            return $categories;
        }
        $categories->push($category);
        while($category = $category->getParent()) {
            $categories->push($category);
        }
        return $categories->reverse();
    }
    
    /**
     * Get children ids list for category by slug
     *
     * @param string $slug
     * @return EloquentCollection|null|Category[]
     */
    public static function getSameCategories(string $slug): ?EloquentCollection
    {
        return Category::getOneBySlug($slug)->getSame();
    }
    
    /**
     * @param string $slug
     * @return EloquentCollection|null
     */
    public static function getKidsOrSameCategoriesIfEmpty(string $slug): ?EloquentCollection
    {
        return Category::getOneBySlug($slug)->getKidsOrSameIfEmpty();
    }

    /**
     * Get children ids list for category by id
     *
     * @param int|null $categoryId
     * @return array
     */
    public static function getAllChildrenIds(?int $categoryId = null): array
    {
        return Category::getChildrenIdsFromCollection(Category::tree(), $categoryId);
    }
    
    /**
     * Get children ids list for category from existing list by category id
     *
     * @param Collection|Category[][] $categories
     * @param int|null $categoryId
     * @return array
     */
    public static function getChildrenIdsFromCollection(Collection $categories, ?int $categoryId = null): array
    {
        $childrenIds = [];
        foreach ($categories->get((int)$categoryId, []) as $category) {
            $childrenIds[] = $category->id;
            $childrenIds = array_merge($childrenIds, Category::getChildrenIdsFromCollection($categories, $category->id));
        }
        return $childrenIds;
    }
    
    /**
     * Category link in admin panel
     *
     * @return string
     */
    public function getLinkInAdminPanelAttribute(): string
    {
        return route('admin.categories.edit', ['category' => $this->id]);
    }
    
    /**
     * Top level of categories
     *
     * @return Category[]|Builder[]|EloquentCollection
     */
    public static function topLevel()
    {
        return Category::with('current')
            ->active(true)
            ->where(function(Builder $query) {
                $query
                    ->where('parent_id', 0)
                    ->orWhereNull('parent_id');
            })
            ->oldest('position')
            ->latest('id')
            ->get();
    }
    
    /**
     * Link on category inner page
     *
     * @return string
     */
    public function getSiteLinkAttribute(): string
    {
        return route('site.category', ['slug' => $this->current->slug]);
    }
    
    /**
     * @return bool
     */
    public function getHasChildrenAttribute(): bool
    {
        return $this->children && $this->children->isNotEmpty();
    }
    
    /**
     * @return bool
     */
    public function getHasActiveChildrenAttribute(): bool
    {
        return $this->getKids()->isNotEmpty();
    }


    /**
     * @param int $id
     * @return array|null
     */
    public function getPagesLinksByIdForImage(int $id)
    {
        $links = [];
        $item = Category::active()->find($id);
        if($item){
            if($item->parent){
                $links[] = url(route('site.category', ['slug' => $item->parent->current->slug], false), [], isSecure());
            } else {
                $links[] = url(route('site.categories', [], false), [], isSecure());
            }

        }
        return $links;
    }
    
    public function moveKidsToTheParentCategory(): void
    {
        Category::whereParentId($this->id)->update([
            'parent_id' => $this->parent_id,
        ]);
    }
}
