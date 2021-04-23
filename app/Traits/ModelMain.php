<?php namespace App\Traits;

use DB, Lang;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Trait ModelMain
 *
 * Методы для работы с основной таблицей, имеющей таблицу в БД с переводами
 *
 * @package  App\Traits
 * @property \Illuminate\Database\Eloquent\Collection $data
 * @property $this $current
 * @property object|mixed|null $dataFor
 */
trait ModelMain
{
    
    public static function relatedModelName()
    {
        $currentClass = static::class;
        $translatesClass = $currentClass . 'Translates';
        return $translatesClass;
    }
    
    public static function getRelatedTableName()
    {
        $relatedModelName = static::relatedModelName();
        $relatedModel = new $relatedModelName;
        return $relatedModel->getTable();
    }
    
    public function data()
    {
        return $this->hasMany($this->relatedModelName(), 'row_id', 'id');
    }
    
    public function current()
    {
        if (config('app.place') === 'site') {
            $currntLanguage = Lang::getLocale();
        } else {
            $currntLanguage = config('app.default-language', app()->getLocale());
        }
        return $this
            ->hasOne($this->relatedModelName(), 'row_id', 'id')
            ->where('language', '=', $currntLanguage)
            ->withDefault();
    }
    
    public function dataForCurrentLanguage($default = null)
    {
        $data = $this->data;
        foreach ($data as $element) {
            if ($element->language === config('app.locale')) {
                return $element;
            }
        }
        return $default;
    }
    
    public function dataFor($lang, $default = null)
    {
        $data = $this->data;
        foreach ($data as $element) {
            if ($element->language === $lang) {
                return $element;
            }
        }
        return $default;
    }
    
    /**
     * @param  Request $request
     * @param string|null $imageGroupType
     * @return string|null
     */
    public function createRow(Request $request, ?string $imageGroupType = null): ?string
    {
        try {
            DB::beginTransaction();
            $this->fill($request->input() ?: []);
            if ($this->save() !== true) {
                return 'Can not execute SQL request!';
            }
            if (method_exists($this, 'uploadImage')) {
                $this->uploadImage($imageGroupType);
            }
            $modelName = $this->relatedModelName();
            foreach (config('languages', []) AS $language) {
                $translate = new $modelName();
                $translate->fill($request->input($language['slug']) ?: []);
                $translate->language = $language['slug'];
                $translate->row_id = $this->id;
                $translate->save();
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $exception->getMessage();
        }
        return null;
    }
    
    /**
     * @param Request $request
     * @param string|null $imageGroupType
     * @return string|null
     */
    public function updateRow(Request $request, ?string $imageGroupType = null): ?string
    {
        try {
            DB::beginTransaction();
            $this->fill($request->input());
            $changes = [];
            if ($this->isDirty()) {
                $changes['main'] = array_keys($this->getDirty());
            }
            if ($this->save() !== true) {
                return 'Can not execute SQL request!';
            }
            if (method_exists($this, 'uploadImage')) {
                $this->uploadImage($imageGroupType);
            }
            $modelName = $this->relatedModelName();
            foreach (config('languages', []) AS $language) {
                $translate = $this->dataFor($language['slug']);
                if (!$translate) {
                    $translate = new $modelName();
                }
                $translate->fill($request->input($language['slug'], []));
                $translate->row_id = $this->id;
                $translate->language = $language['slug'];
                if ($translate->isDirty()) {
                    $changes[$translate->language] = array_keys($translate->getDirty());
                }
                $translate->save();
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $exception->getMessage();
        }
        return null;
    }
    
    /**
     * Delete row from the database
     *
     * @return bool
     */
    public function deleteRow()
    {
        try {
            if (method_exists($this, 'deleteImagesIfExist')) {
                $this->deleteImagesIfExist();
            }
            $this->delete();
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }
    
    /**
     * Get row by filed in `current` relation
     *
     * @param string $field
     * @param null $value
     * @return \Illuminate\Database\Eloquent\Builder|Model
     */
    public static function getByCurrent(string $field, $value)
    {
        return static::with('current')
            ->whereHas('current', function (Builder $query) use ($field, $value) {
                $query->where($field, $value);
            })
            ->first();
    }
    
}
