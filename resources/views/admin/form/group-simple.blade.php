<?php
/** @var Illuminate\Support\ViewErrorBag $errors */
/** @var CustomForm\Group\Group $element */

$error = isset($errors) ? $errors->first($element->getErrorSessionKey()) : null;
if ($error) {
    $element->addClassesToDiv('has-error');
}
?>
<div {!! Html::attributes($element->getBlockOptions()) !!}>
    @foreach($element->getElements() as $checkbox)
        {!! $checkbox->render() !!}
    @endforeach
</div>
