<?php

namespace App\Modules\Reviews\Forms;

use App\Components\Form\ObjectValues\ModelForSelect;
use App\Core\Interfaces\FormInterface;
use App\Modules\Reviews\Models\Review;
use App\Modules\Users\Models\User;
use CustomForm\Builder\Form;
use CustomForm\Image;
use CustomForm\Input;
use CustomForm\Macro\DateTimePicker;
use CustomForm\Macro\Toggle;
use CustomForm\Select;
use CustomForm\Text;
use CustomForm\TinyMce;
use Illuminate\Database\Eloquent\Model;
use Html, Widget;

/**
 * Class AdminReviewForm
 *
 * @package App\Core\Modules\Administrators\Forms
 */
class AdminReviewForm implements FormInterface
{
    
    /**
     * @param  Model|Review|null $review
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $review = null): Form
    {
        $review = $review ?? new Review;
        $form = Form::create();
    
        if ($review && $review->exists) {
            if ($review->user_id) {
                $user = Text::create('user')
                    ->setDefaultValue(Widget::show('short-user-information', $review->user));
            } else {
                $user = Text::create('user')
                    ->setDefaultValue(
                        Html::tag(
                            'div',
                            trans('orders::general.no-user-selected'),
                            [
                                'class' => ['form-group', 'text-bold', 'text-red']
                            ]
                        )
                    );
            }
        } else {
            $user = Text::create('user')
                ->setDefaultValue(Widget::show('live-search-user'));
        }
        
        // Field set with languages tabs
        $form->fieldSet()->add(
            $user,
            Toggle::create('active', $review),
            DateTimePicker::create('published_at', $review)->required(),
            Input::create('name', $review)->setLabel('validation.attributes.first_name')->required(),
            Input::create('email', $review)->setType('email'),
            TinyMce::create('comment', $review)->required()
        );
        return $form;
    }
    
}
