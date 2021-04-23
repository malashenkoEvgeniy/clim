<?php
/** @var Illuminate\Support\ViewErrorBag $errors */
/** @var CustomForm\Select $element */

$error = $errors->first($element->getErrorSessionKey());
if ($error) {
    $element->addClassesToDiv('has-error');
}
?>
<div {!! Html::attributes($element->getBlockOptions()) !!}>
    @include('admin.form.components.label', ['element' => $element])
    {!! Form::select($element->getName(), $element->getList(), $element->getValue(), $element->getOptions()) !!}
    @include('admin.form.components.helper', ['element' => $element])
</div>
