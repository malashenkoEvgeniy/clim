<?php
/** @var CustomForm\Hidden $element */
?>
{!! Form::input('hidden', $element->getName(), $element->getValue(), $element->getOptions()) !!}
