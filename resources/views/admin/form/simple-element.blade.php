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
    {!! $element->getValue() !!}
    @include('admin.form.components.helper', ['element' => $element])
</div>
