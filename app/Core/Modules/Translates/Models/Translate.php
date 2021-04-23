<?php

namespace App\Core\Modules\Translates\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Schema;
use EloquentFilter\Filterable;

/**
 * Class Translate
 *
 * @property int $id
 * @property string $name
 * @property string|null $module
 * @property string|null $place
 * @property string|null $text
 * @property array|null $help
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate whereHelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Translates\Models\Translate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Translate extends Model
{
    use Filterable;
    
    const PLACE_SITE = 'site';
    const PLACE_ADMIN = 'admin';
    const PLACE_GENERAL = 'general';

    protected $casts = ['help' => 'array'];

    protected $fillable = ['name', 'text', 'module', 'language', 'help', 'place'];
    
    /**
     * @param array $translates
     * @param string $module
     */
    public static function setTranslates(array $translates, string $module)
    {
        if (Schema::hasTable('translates')) {
            foreach ($translates as $place => $list) {
                $currentModule = ($place === 'general') ? '*' : $module;
                $currentPlace = ($place === 'general') ? null : $place;
                foreach ($list as $translate) {
                    foreach ($translate as $lang => $text) {
                        if (strlen($lang) !== 2) {
                            continue;
                        }
                        $name = array_get($translate, 'name');
                        $help = array_get($translate, 'help');
                        $translate = Translate::getTranslate($name, $currentModule, $currentPlace, $lang);
                        if ($translate && $translate->exists) {
                            if ($translate->help !== $help) {
                                $translate->update(['help' => $help]);
                            }
                            continue;
                        }
                        Translate::create([
                            'place' => $currentPlace,
                            'name' => $name,
                            'language' => $lang,
                            'module' => $currentModule,
                            'text' => $text ?? '',
                            'help' => $help,
                        ]);
                    }
                }
            }
        }
    }
    
    /**
     * @param string $name
     * @param string $module
     * @param string|null $place
     * @param string $lang
     * @return Translate|null
     */
    public static function getTranslate(string $name, string $module, ?string $place, string $lang): ?Translate
    {
        $translate = Translate::query()
            ->whereName($name)
            ->whereLanguage($lang)
            ->whereModule($module);
        if ($place === null) {
            $translate->whereNull('place');
        } else {
            $translate->wherePlace($place);
        }
        return $translate->first();
    }

    /**
     * @param string|null $place
     * @param array $langsKeys
     * @return array
     */
    public static function getTranslates(?string $place, array $langsKeys): array
    {
        $translates = [];
        
        $query = Translate::query();
        if ($place) {
            $query->wherePlace($place);
        } else {
            $query->whereNull('place');
        }
    
        $allTranslates = [];
        $query
            ->whereIn('language', $langsKeys)
            ->get()
            ->each(function (Translate $translate) use (&$translates, &$allTranslates) {
                $translates[$translate->module][$translate->name][$translate->language] = $translate->text;
                $allTranslates[$translate->module][$translate->name][$translate->language] = $translate->text;
            });
        $translates['all-translates'] = $allTranslates;
        return $translates;
    }

    /**
     * @param string $place
     * @return bool
     */
    public static function setTranslate(string $place): bool
    {
        $name = request()->input('key');
        $text = request()->input('value');
        $language = request()->input('lang');

        list($module, $name) = explode('::', "$name::");
        if (!$name) {
            $name = $module;
            $module = '*';
        }
        if($place == 'general'){
            $place = null;
        }

        $translate = Translate::query()->updateOrCreate([
            'place' => $place,
            'name' => $name,
            'language' => $language,
            'module' => $module,
        ], [
            'text' => $text,
        ]);

        return $translate->exists;
    }


    public static function getTranslatesList()
    {
        foreach (app()->getLoadedProviders() as $providerNamespace => $isLoaded) {
            if (
                strpos($providerNamespace, 'App\Modules') === 0 ||
                strpos($providerNamespace, 'App\Core\Modules') === 0
            ) {
                $provider = app()->getProvider($providerNamespace);
                if(method_exists($provider,'getTranslationFolder') && is_dir($provider->getTranslationFolder().'/ru')){
                    $files = scandir($provider->getTranslationFolder().'/ru');
                    foreach($files as $file) {
                        if($file === '.' || $file === '..') {
                            continue;
                        }
                        $fileName = Str::substr($file,0,Str::length($file)-4);
                        $moduleForTranslate = $provider->getModuleName().'::'.$fileName;
                        $moduleFiles[$moduleForTranslate] = require($provider->getTranslationFolder().'/ru/'.$file);
                        $translatesFroml18n = Arr::dot($moduleFiles);
                    }
                }
            }
        }
        $filesFromResources = scandir(resource_path().'/lang/ru');
        foreach($filesFromResources as $filesFromResource) {
            if ($filesFromResource === '.' || $filesFromResource === '..') {
                continue;
            }
            $fileFromResourceName = Str::substr($filesFromResource,0,Str::length($filesFromResource)-4);
            $resourceTranslates[$fileFromResourceName] = require(resource_path().'/lang/ru/'.$filesFromResource);
            $translatesFromResources = Arr::dot($resourceTranslates);
        }
        $translatesFromDatabase = Translate::get()->mapWithKeys(function ($item) {
            if($item['module'] == '*'){
                return [$item['name'] => $item['text']];
            }else{
                return [$item['module'].'::'.$item['name'] => $item['text']];
            }

        })->toArray();;
        $allTranslates = $translatesFromDatabase;
        $allTranslates +=  $translatesFroml18n ;
        $allTranslates += $translatesFromResources;

        $allTranslates = array_unique($allTranslates);

        return  $allTranslates;

    }

}
