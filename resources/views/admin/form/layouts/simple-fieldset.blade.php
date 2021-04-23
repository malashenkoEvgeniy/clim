@php
/** @var \CustomForm\Builder\FieldSetSimple $fieldSet */
@endphp

@foreach($fieldSet->getFields() as $field)
    {!! $field->render() !!}
@endforeach