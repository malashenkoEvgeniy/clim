<?php

namespace App\Modules\Comments\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Comments\Models\Comment;
use App\Modules\Comments\Requests\SiteCommentRequest;

/**
 * Class ProductReviewForm
 *
 * @package App\Modules\Comments\Widgets\Site
 */
class ProductReviewForm implements AbstractWidget
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
        $formId = uniqid('form-product-review');
        $validation = \JsValidator::make(
            (new SiteCommentRequest())->rules(),
            [],
            [],
            "#$formId"
        );
//        dd(\Auth::user());
        return view('comments::site.product-review-form', [
            'productId' => $this->commentableId,
            'type' => $this->commentableType,
            'formId' => $formId,
            'validation' => $validation,
        ]);
    }
    
}
