<?php

namespace App\Core\Modules\News\Filters;

use Carbon\Carbon;
use CustomForm\Builder\Form;
use CustomForm\Macro\DateRangePicker;
use CustomForm\Select;
use CustomForm\Input;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Class NewsFilter
 *
 * @package App\Core\Modules\News\Filters
 */
class NewsFilter extends ModelFilter
{
    /**
     * Generate form view
     *
     * @return string
     * @throws \App\Exceptions\WrongParametersException
     */
    static function showFilter()
    {
        $form = Form::create();
        $form->fieldSetForFilter()->add(
            Input::create('name')->setValue(request('name'))
                ->addClassesToDiv('col-md-3'),
            DateRangePicker::create('published_at')
                ->setValue(request('published_at'))
                ->addClassesToDiv('col-md-2'),
            Select::create('active')
                ->add([
                    '0' => __('global.unpublished'),
                    '1' => __('global.published'),
                ])
                ->setValue(request('active'))
                ->addClassesToDiv('col-md-2')
                ->setPlaceholder(__('global.all'))
        );
        return $form->renderAsFilter();
    }

    /**
     * Filter by name
     *
     * @param  string $name
     * @return NewsFilter
     */
    public function name(string $name)
    {
        $name = Str::lower($name);
        return $this->related('current', function (Builder $query) use ($name) {
            return $query->whereRaw('LOWER(name) LIKE ?', ["%$name%"]);
        });
    }

    /**
     * @param string $publishedAt
     * @return $this
     */
    public function publishedAt(string $publishedAt)
    {
        $range = explode(' - ', $publishedAt);
        $startDate = Carbon::parse($range[0])->startOfDay();
        $endDate = Carbon::parse($range[1])->endOfDay();
        return $this->where(
            function (Builder $query) use ($startDate, $endDate) {
                return $query->where('published_at', '>=', $startDate)
                    ->where('published_at', '<=', $endDate);
            }
        );
    }

    /**
     * Filter by active
     *
     * @param  string $active
     * @return NewsFilter
     */
    public function active(string $active)
    {
        return $this->where(
            function (Builder $query) use ($active) {
                return $query->whereActive((bool)$active);
            }
        );
    }
}
