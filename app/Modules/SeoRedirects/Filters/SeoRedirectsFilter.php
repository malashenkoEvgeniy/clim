<?php

namespace App\Modules\SeoRedirects\Filters;

use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Select;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class SeoRedirectsFilter
 *
 * @package App\Core\Modules\SeoRedirects\Filters
 */
class SeoRedirectsFilter extends ModelFilter
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
            Input::create('link_from')->setValue(request('link_from'))->setLabel(__('seo_redirects::general.link_from'))
                ->addClassesToDiv('col-md-3'),
            Input::create('link_to')->setValue(request('link_to'))->setLabel(__('seo_redirects::general.link_to'))
                ->addClassesToDiv('col-md-3'),
            Select::create('type')
                ->add(config('seo_redirects.types', []))
                ->setValue(request('type'))
                ->addClassesToDiv('col-md-2')
                ->setPlaceholder(__('global.all'))
                ->setLabel(__('seo_redirects::general.type')),
            Select::create('active')
                ->add([
                    0 => __('global.unpublished'),
                    1 => __('global.published')
                ])
                ->setValue(request('active'))
                ->addClassesToDiv('col-md-2')
                ->setPlaceholder(__('global.all'))
        );
        return $form->renderAsFilter();
    }

    /**
     * Filter by linkFrom
     *
     * @param  string $linkFrom
     * @return SeoRedirectsFilter
     */
    public function linkFrom(string $linkFrom)
    {
        return $this->where(function (Builder $query) use ($linkFrom) {
            return $query->where('link_from', $linkFrom);
        });
    }

    /**
     * Filter by linkTo
     *
     * @param  string $linkTo
     * @return SeoRedirectsFilter
     */
    public function linkTo(string $linkTo)
    {
        return $this->where(function (Builder $query) use ($linkTo) {
            return $query->where('link_to', $linkTo);
        });
    }

    /**
     * Filter by type
     *
     * @param  string $type
     * @return SeoRedirectsFilter
     */
    public function type(string $type)
    {
        return $this->where(function (Builder $query) use ($type) {
            return $query->whereType((int)$type);
        });
    }

    /**
     * Filter by active
     *
     * @param  string $active
     * @return SeoRedirectsFilter
     */
    public function active(string $active)
    {
        return $this->where(function (Builder $query) use ($active) {
            return $query->whereActive((bool)$active);
        });
    }
}
