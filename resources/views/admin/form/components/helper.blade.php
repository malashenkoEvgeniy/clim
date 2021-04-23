<?php
/** @var Illuminate\Support\ViewErrorBag $errors */
/** @var CustomForm\Input $element */

$error = isset($errors) ? $errors->first($element->getErrorSessionKey()) : null;
?>
@if($error)
    <span class="help-block error-help-block">{{ $error }}</span>
@elseif($element->getHelp())
    <span class="help-block">{{ $element->getHelp() }}</span>
@endif
