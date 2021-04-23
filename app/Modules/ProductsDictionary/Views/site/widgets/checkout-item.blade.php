@php
    /** @var \CustomForm\Select $dictionarySelect */
    /** @var array $values */
@endphp

@if(!empty($values))
    {!! $dictionarySelect->render() !!}
@endif
