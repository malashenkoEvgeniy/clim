<?php

namespace App\Core\Modules\Languages\Models;

use Illuminate\Database\Eloquent\Model;
use Route, Lang;

/**
 * App\Core\Modules\Languages\Models\Language
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property bool $default Язык по-умолчанию
 * @property string|null $google_slug
 * @property-read mixed|string $current_url_with_new_language
 * @property-read bool $is_current
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Languages\Models\Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Languages\Models\Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Languages\Models\Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Languages\Models\Language whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Languages\Models\Language whereGoogleSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Languages\Models\Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Languages\Models\Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Languages\Models\Language whereSlug($value)
 * @mixin \Eloquent
 */
class Language extends Model
{
    public $timestamps = false;

    protected $casts = ['default' => 'boolean'];

    protected $fillable = ['name', 'default'];

    static $links = [];

    /**
     * Set current language as default
     * Turn off `default` label for other languages
     *
     * @return bool
     */
    public function setAsDefault()
    {
        Language::whereDefault(true)->update([
            'default' => false,
        ]);
        $this->default = true;
        return $this->save();
    }

    /**
     * Change language for current URL
     *
     * @return mixed|string
     */
    public function getCurrentUrlWithNewLanguageAttribute(): string
    {
        if (isset(static::$links[$this->slug])) {
            $url = static::$links[$this->slug];
        } else {
            $url = $_SERVER['REQUEST_URI'];
        }
        if (Route::current()) {
            $url = str_replace('/' . Route::current()->getPrefix() . '/', '/', $url . '/');
            if ($this->default) {
                return $url;
            }
        }
        return url($this->slug . $url);
    }

    /**
     * Is this language is current
     *
     * @return bool
     */
    public function getIsCurrentAttribute(): bool
    {
        return $this->slug === Lang::getLocale();
    }

    /**
     * Sets URL list for model for current URL changing
     *
     * @param Model $model
     */
    public static function otherLanguagesLinks(Model $model)
    {
        if (method_exists($model, 'data')) {
            foreach ($model->data as $translate) {
                $parameters = Route::current()->parameters();
                if (isset($parameters['slug'])) {
                    $parameters['slug'] = $translate->slug;
                }
                static::$links[$translate->language] = route(Route::currentRouteName(), $parameters, false);
            }
        }
    }
}
