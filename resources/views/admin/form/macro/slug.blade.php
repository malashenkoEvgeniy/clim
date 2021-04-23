<?php
/** @var Illuminate\Support\ViewErrorBag $errors */
/** @var CustomForm\Input $element */

$error = $errors->first($element->getErrorSessionKey());
if ($error) {
    $element->addClassesToDiv('has-error');
}
?>
<div {!! Html::attributes($element->getBlockOptions()) !!}>
    @include('admin.form.components.label', ['element' => $element])
    <div class="input-group">
        {!! Form::input($element->getType(), $element->getName(), $element->getValue(), $element->getOptions()) !!}
        <span class="input-group-btn">
            <button type="button" data-url="{{ route('admin.translit') }}" class="btn btn-info btn-flat" data-slug-button>
                {{ __('admin.buttons.translit') }}
            </button>
        </span>
    </div>
    @include('admin.form.components.helper', ['element' => $element])
</div>
