<?php
/** @var Illuminate\Support\ViewErrorBag $errors */
/** @var CustomForm\Text $element */

$error = $errors->first($element->getErrorSessionKey());
if ($error) {
    $element->addClassesToDiv('has-error');
}
?>
{!! $element->getValue() !!}
