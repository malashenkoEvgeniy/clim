<?php
/** @var CustomForm\Input $element */
$text = $element->getLabel();
if (Lang::has($text)) {
    $text = __($text);
}
?>
@if($element->getLabel())
    {!!
         Form::label(
             $element->getName(),
             $text . ($element->isRequired() ? ' <span class="text-red">*</span>' : null),
             ['class' => 'control-label'],
             false
         )
    !!}
@endif
