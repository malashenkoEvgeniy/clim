<?php

namespace App\Modules\News\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\News\Models\News as NewsModel;

class News implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $news = NewsModel::newsForWidget();
        if (!$news || !$news->count()) {
            return null;
        }
        return view('news::site.widget', [
            'news' => $news,
        ]);
    }
    
}
