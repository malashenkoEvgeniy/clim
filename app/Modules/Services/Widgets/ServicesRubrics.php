<?php

namespace App\Modules\Services\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Articles\Models\Article as ArticleModel;
use App\Modules\Services\Models\Service;
use App\Modules\Services\Models\ServicesRubric;

/**
 * Class LastArticles
 *
 * @package App\Modules\News\Widgets
 */
class ServicesRubrics implements AbstractWidget
{
    
    /**
     * @var null|int
     */
    protected $servicesRubricId;
    
    /**
     * SameArticles constructor.
     *
     * @param int|null $articleId
     */
    public function __construct(?int $servicesRubricId = null)
    {
        $this->servicesRubricId = $servicesRubricId;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $servicesRubrics = Service::getList();
        if (!$servicesRubrics || !$servicesRubrics->count()) {
            return null;
        }
        return view('services::site.widgets.services-rubrics', [
            'services' => $servicesRubrics,
        ]);
    }
    
}
