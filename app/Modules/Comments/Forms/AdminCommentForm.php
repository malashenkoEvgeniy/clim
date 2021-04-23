<?php

namespace App\Modules\Comments\Forms;

use App\Components\Form\ObjectValues\ModelForSelect;
use App\Core\Interfaces\FormInterface;
use App\Modules\Comments\Models\Comment;
use App\Modules\Users\Models\User;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\DateTimePicker;
use CustomForm\Macro\Toggle;
use CustomForm\Select;
use CustomForm\Text;
use CustomForm\TinyMce;
use CustomForm\WysiHtml5;
use Illuminate\Database\Eloquent\Model;
use Widget, Html;

/**
 * Class AdminCommentForm
 *
 * @package App\Core\Modules\Comments\Forms
 */
class AdminCommentForm implements FormInterface
{
    
    /**
     * @param  Model|Comment|null $comment
     * @param  string|null $morphClass
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $comment = null, string $morphClass = null): Form
    {
        $comment = $comment ?? new Comment;
    
        if ($comment && $comment->exists) {
            if ($comment->user_id) {
                $user = Text::create('user')
                    ->setDefaultValue(Widget::show('short-user-information', $comment->user));
            }
        } else {
            $user = Text::create('user')
                ->setDefaultValue(Widget::show('live-search-user'));
        }
        
        $form = Form::create();
        // Field set with languages tabs
        $form->fieldSet(7)->add(
            $morphClass ? $morphClass::formElementForComments($comment->commentable_id) : null,
            DateTimePicker::create('published_at', $comment)->required(),
            Input::create('name', $comment)->setLabel('validation.attributes.first_name')->required(),
            Input::create('email', $comment)->required(),
            WysiHtml5::create('comment', $comment)->required()
        );
        $form->fieldSet(5)->add(
            $user ?? null,
            Toggle::create('active', $comment),
            Select::create('mark', $comment)
                ->setPlaceholder('&mdash;')
                ->add([1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5]),
            DateTimePicker::create('answered_at', $comment),
            WysiHtml5::create('answer', $comment)
        );
        return $form;
    }
    
}
