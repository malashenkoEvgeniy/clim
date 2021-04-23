<?php

namespace App\Core\Modules\Mail\Models;

use App\Traits\ModelMain;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Modules\Mail\Models\MailTemplate
 *
 * @property int $id
 * @property string $alias
 * @property string $name
 * @property array|null $variables
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Core\Modules\Mail\Models\MailTemplateTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Mail\Models\MailTemplateTranslates[] $data
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplate published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplate whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplate whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplate whereVariables($value)
 * @mixin \Eloquent
 */
class MailTemplate extends Model
{
    use ModelMain;
    
    protected $casts = ['active' => 'boolean', 'variables' => 'array'];
    
    protected $fillable = ['active'];
    
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
     * Mail templates list
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList()
    {
        return MailTemplate::with(['current'])->oldest()->paginate(config('db.mail_templates.per-page', 10));
    }
    
    /**
     * Get mail template eloquent object by alias
     *
     * @param string $alias
     * @return MailTemplate|\Illuminate\Database\Eloquent\Builder|Model|null|object
     */
    public static function getTemplateByAlias(string $alias)
    {
        return MailTemplate::with(['current'])->published()->whereAlias($alias)->first();
    }
}
