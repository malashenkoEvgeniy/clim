<?php

namespace App\Modules\News\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\News\Models\News as NewsModel;

class SameNews implements AbstractWidget
{
    
    /**
     * @var null|int
     */
    protected $newsId;
    
    /**
     * SameNews constructor.
     *
     * @param int|null $newsId
     */
    public function __construct(?int $newsId = null)
    {
        $this->newsId = $newsId;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $news = NewsModel::sameNews($this->newsId, 4);
        if (!$news || !$news->count()) {
            return null;
        }
        return view('news::site.widgets.same-news', [
            'news' => $news,
        ]);
    }
    
}
