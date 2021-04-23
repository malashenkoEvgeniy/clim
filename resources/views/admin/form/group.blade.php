<?php
/** @var Illuminate\Support\ViewErrorBag $errors */
/** @var CustomForm\Group\Group $element */

$error = isset($errors) ? $errors->first($element->getErrorSessionKey()) : null;
if ($error) {
    $element->addClassesToDiv('has-error');
}
?>
<div {!! Html::attributes($element->getBlockOptions()) !!}>
    @include('admin.form.components.label', ['element' => $element])
    <div>
        @foreach($element->getElements() as $checkbox)
            <div class="{{ $checkbox->getClassToDiv() }}">
                <label>{!! $checkbox->render($element->getValue()) !!} {{ $checkbox->getLabel() }}</label>
            </div>
        @endforeach
    </div>
    @include('admin.form.components.helper', ['element' => $element])
</div>
