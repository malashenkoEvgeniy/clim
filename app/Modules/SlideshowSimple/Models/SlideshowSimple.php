<?php

namespace App\Modules\SlideshowSimple\Models;

use App\Core\Modules\Languages\Models\Language;
use App\Modules\SlideshowSimple\Images\SliderImage;
use App\Traits\ActiveScopeTrait;
use App\Traits\Imageable;
use App\Traits\ModelMain;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\SlideshowSimple\Models\SlideshowSimple
 *
 * @property int $id
 * @property int $position
 * @property bool $active
 * @property string|null $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Images\Models\Image[] $allImages
 * @property-read \App\Modules\SlideshowSimple\Models\SlideshowSimpleTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SlideshowSimple\Models\SlideshowSimpleTranslates[] $data
 * @property-read \App\Core\Modules\Images\Models\Image $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Images\Models\Image[] $images
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SlideshowSimple\Models\SlideshowSimple active($active = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SlideshowSimple\Models\SlideshowSimple newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SlideshowSimple\Models\SlideshowSimple newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SlideshowSimple\Models\SlideshowSimple query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SlideshowSimple\Models\SlideshowSimple whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SlideshowSimple\Models\SlideshowSimple whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SlideshowSimple\Models\SlideshowSimple whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SlideshowSimple\Models\SlideshowSimple wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SlideshowSimple\Models\SlideshowSimple whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SlideshowSimple\Models\SlideshowSimple whereUrl($value)
 * @mixin \Eloquent
 */
class SlideshowSimple extends Model
{
    use ModelMain, Imageable, ActiveScopeTrait;

    protected $table = 'slideshow_simple';

    protected $casts = ['active' => 'boolean'];

    protected $fillable = ['active', 'url'];

    /**
     * Image config
     *
     * @return string|array
     */
    protected function imageClass()
    {
        return [
            SliderImage::class,
        ];
    }

    /**
     * Get list of slides
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList()
    {
        return SlideshowSimple::with(['current'])
            ->oldest('position')
            ->get();
    }

    public static function getAllActive()
    {
        return SlideshowSimple::with(['image', 'image.current'])->active(true)->oldest('position')->get();
    }


    /**
     * @param int $id
     * @return array|null
     */
    public function getPagesLinksByIdForImage(int $id)
    {
        $links = [];
        $item = SlideshowSimple::active()->find($id);
        if($item){
            $languages = config('languages', []);
            /** @var Language $language */
            foreach($languages as $language){
                $prefix = $language->default ? '' : '/'.$language->slug;
                $links[] = url($prefix . route('site.home', [], false), [], isSecure());
            }
        }
        return $links;
    }
}
