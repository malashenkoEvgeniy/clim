<?php

namespace App\Modules\Import\Models;

use App\Modules\Currencies\Models\Currency;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Import\Models\Import
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $currency
 * @property string $status
 * @property string|null $message
 * @property array|null $data
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\Import newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\Import newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\Import query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\Import whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\Import whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\Import whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\Import whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\Import whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\Import whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Import\Models\Import whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Import extends Model
{
    const STATUS_NEW = 'new';
    const STATUS_PROCESSING = 'processing';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';
    
    protected $table = 'imports';
    
    protected $fillable = ['status', 'message', 'data', 'currency'];
    
    protected $casts = ['data' => 'array'];
    
    /**
     * @param array $data
     * @return Import
     * @throws \Throwable
     */
    public static function start(array $data = []): self
    {
        $currency = Currency::whereDefaultInAdminPanel(true)->firstOrFail();
        
        $import = new Import;
        $import->status = static::STATUS_NEW;
        $import->data = $data;
        $import->currency = $currency->microdata;
        $import->saveOrFail();
        
        return $import;
    }
    
    /**
     * @return Import|null
     */
    public static function getLast(): ?self
    {
        return Import::latest('id')->first();
    }
    
    /**
     * @return bool
     */
    public function isInProcess(): bool
    {
        return $this->status !== static::STATUS_DONE && $this->status !== static::STATUS_FAILED;
    }
    
}
