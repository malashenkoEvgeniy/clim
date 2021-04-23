<?php

namespace App\Modules\Comments\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Comments\Models\Comment;

/**
 * Class ProductReviews
 *
 * @package App\Modules\Comments\Widgets\Site
 */
class ProductReviews implements AbstractWidget
{
    
    /**
     * @var int|null
     */
    protected $commentableId;
    
    /**
     * @var string
     */
    protected $commentableType;
    
    /**
     * ProductAmount constructor.
     *
     * @param string $commentableType
     * @param int|null $productId
     */
    public function __construct(string $commentableType, ?int $productId = null)
    {
        $this->commentableType = $commentableType;
        $this->commentableId = $productId;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (!$this->commentableId || !$this->commentableType) {
            return null;
        }
        $comments = Comment::getListForCommentable(
            $this->commentableId,
            $this->commentableType
        );
        if (!$comments || $comments->isEmpty()) {
            return null;
        }
        return view('comments::site.product-reviews', [
            'comments' => $comments,
            'commentableId' => $this->commentableId,
            'commentableType' => $this->commentableType,
        ]);
    }
    
}
