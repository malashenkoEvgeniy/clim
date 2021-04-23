<?php

namespace App\Modules\Currencies\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

/**
 * App\Modules\Currencies\Models\Currency
 *
 * @property int $id
 * @property bool $default_on_site
 * @property bool $default_in_admin_panel
 * @property string $name
 * @property string $sign
 * @property float $multiplier
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $microdata
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Currencies\Models\Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Currencies\Models\Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Currencies\Models\Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Currencies\Models\Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Currencies\Models\Currency whereDefaultInAdminPanel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Currencies\Models\Currency whereDefaultOnSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Currencies\Models\Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Currencies\Models\Currency whereMicrodata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Currencies\Models\Currency whereMultiplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Currencies\Models\Currency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Currencies\Models\Currency whereSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Currencies\Models\Currency whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Currency extends Model
{
    
    protected $casts = ['default_on_site' => 'boolean', 'default_in_admin_panel' => 'boolean'];
    
    protected $fillable = ['name', 'sign', 'multiplier'];
    
    /**
     * Returns all available currencies
     *
     * @return Currency[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getList()
    {
        return Currency::oldest('name')->get();
    }
    
    /**
     * Create new currency
     *
     * @param Request $request
     * @return bool
     */
    public function updateOrCreateNew(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->fill($request->all());
            if ($this->default_on_site === true) {
                $this->setOtherCurrenciesAsNotDefaultOnSite();
            }
            if ($this->default_in_admin_panel === true) {
                $this->setOtherCurrenciesAsNotDefaultInAdminPanel();
            }
            $this->save();
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }
    }
    
    /**
     * Set all currencies as not default on the site except current
     *
     * @return bool|int
     */
    public function setOtherCurrenciesAsNotDefaultOnSite()
    {
        return Currency::whereDefaultOnSite(true)
            ->where('id', '!=', $this->id)
            ->update([
                'default_on_site' => false,
            ]);
    }
    
    /**
     * Set all currencies as not default in admin panel except current
     *
     * @return bool|int
     */
    public function setOtherCurrenciesAsNotDefaultInAdminPanel()
    {
        return Currency::whereDefaultInAdminPanel(true)
            ->where('id', '!=', $this->id)
            ->update([
                'default_in_admin_panel' => false,
            ]);
    }
    
    /**
     * Set chosen currency as default for site
     *
     * @return bool
     */
    public function setAsDefaultOnSite()
    {
        try {
            DB::beginTransaction();
            $this->default_on_site = true;
            $this->setOtherCurrenciesAsNotDefaultOnSite();
            $this->save();
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }
    }
    
    /**
     * Set chosen currency as default for admin panel
     *
     * @return bool
     */
    public function setAsDefaultInAdminPanel()
    {
        try {
            DB::beginTransaction();
            $this->default_in_admin_panel = true;
            $this->setOtherCurrenciesAsNotDefaultInAdminPanel();
            $this->save();
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }
    }
    
    /**
     * Returns default site currency
     *
     * @return Currency|\Illuminate\Database\Eloquent\Builder|Model|null|object
     */
    public static function getDefaultOnSite()
    {
        return Currency::whereDefaultOnSite(true)->first();
    }
    
    /**
     * Returns default currency for admin panel
     *
     * @return Currency|\Illuminate\Database\Eloquent\Builder|Model|null|object
     */
    public static function getDefaultInAdminPanel()
    {
        return Currency::whereDefaultInAdminPanel(true)->first();
    }
    
}
