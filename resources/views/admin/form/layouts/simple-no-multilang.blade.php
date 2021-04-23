@php
    /** @var \CustomForm\Builder\FieldSet $fieldSet */
@endphp

@if($fieldSet->isBoxed() && $fieldSet->getTitle())
    <div class="box-header with-border">
        <h3 class="box-title">{{ __($fieldSet->getTitle()) }}</h3>
    </div>
@endif
<div class="{{ $fieldSet->isBoxed() ? 'box-body' : '' }}">
    @foreach($fieldSet->getFields() as $field)
        {!! $field->render() !!}
    @endforeach
</div>
