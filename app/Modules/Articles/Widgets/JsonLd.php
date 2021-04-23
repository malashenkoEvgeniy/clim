<?php

namespace App\Modules\Articles\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Articles\Models\Article as ArticleModel;

/**
 * Class LastArticles
 *
 * @package App\Modules\Articles\Widgets
 */
class JsonLd implements AbstractWidget
{

    /**
     * @var null|int
     */
    protected $article;

    /**
     * JsonLd constructor.
     * @param ArticleModel|null $article
     */
    public function __construct(?ArticleModel $article = null)
    {
        $this->article = $article;
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (!$this->article) {
            return null;
        }
        $logo = null;
        $pathToLogo = 'app/public/' . config('app.logo.path') . '/' . config('app.logo.filename');
        $pathToLogo = preg_replace('/\/{2,}/', '/', $pathToLogo);
        $pathToLogo = storage_path($pathToLogo);
        if (is_file($pathToLogo)) {
            $logo = url(config('app.logo.urlPath') . '/' . config('app.logo.filename')) . '?v=' . filemtime($pathToLogo);
        }
        return view('articles::site.widgets.json-ld', [
            'article' => $this->article,
            'logo' => $logo
        ]);
    }

}
