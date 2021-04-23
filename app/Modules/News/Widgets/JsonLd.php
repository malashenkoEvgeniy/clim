<?php

namespace App\Modules\News\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\News\Models\News as NewsModel;

class JsonLd implements AbstractWidget
{
    /**
     * @var NewsModel|null
     */
    protected $newsItem;

    /**
     * JsonLd constructor.
     * @param NewsModel|null $newsItem
     */
    public function __construct(?NewsModel $newsItem = null)
    {
        $this->newsItem = $newsItem;
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (!$this->newsItem) {
            return null;
        }
        $logo = null;
        $pathToLogo = 'app/public/' . config('app.logo.path') . '/' . config('app.logo.filename');
        $pathToLogo = preg_replace('/\/{2,}/', '/', $pathToLogo);
        $pathToLogo = storage_path($pathToLogo);
        if (is_file($pathToLogo)) {
            $logo = url(config('app.logo.urlPath') . '/' . config('app.logo.filename')) . '?v=' . filemtime($pathToLogo);
        }
        return view('news::site.widgets.json-ld', [
            'news' => $this->newsItem,
            'logo' => $logo
        ]);
    }

}
