<?php

namespace App\Modules\Articles\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Articles\Models\Article as ArticleModel;

/**
 * Class LastArticles
 *
 * @package App\Modules\News\Widgets
 */
class LastArticles implements AbstractWidget
{
    
    /**
     * @var null|int
     */
    protected $articleId;
    
    /**
     * SameArticles constructor.
     *
     * @param int|null $articleId
     */
    public function __construct(?int $articleId = null)
    {
        $this->articleId = $articleId;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $articles = ArticleModel::last($this->articleId, 4);
        if (!$articles || !$articles->count()) {
            return null;
        }
        return view('articles::site.widgets.last-articles', [
            'articles' => $articles,
        ]);
    }
    
}
