<?php

namespace App\Modules\Consultations\Models;

use App\Modules\Consultations\Filters\ConsultationFilter;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Consultations\Models\Consultation
 *
 * @property int $id
 * @property string|null $name
 * @property string $phone
 * @property string|null $question
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Consultations\Models\Consultation filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Consultations\Models\Consultation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Consultations\Models\Consultation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Consultations\Models\Consultation paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Consultations\Models\Consultation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Consultations\Models\Consultation simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Consultations\Models\Consultation whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Consultations\Models\Consultation whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Consultations\Models\Consultation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Consultations\Models\Consultation whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Consultations\Models\Consultation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Consultations\Models\Consultation whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Consultations\Models\Consultation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Consultations\Models\Consultation wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Consultations\Models\Consultation whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Consultations\Models\Consultation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Consultation extends Model
{
    use Filterable;

    protected $table = 'consultations';

    protected $casts = ['active' => 'boolean'];
    
    protected $fillable = ['name', 'phone', 'active', 'question'];

    /**
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(ConsultationFilter::class);
    }
    
    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList()
    {
        return Consultation::filter(request()->all())
            ->latest()
            ->paginate(config('db.consultations.per-page', 10));
    }
}
