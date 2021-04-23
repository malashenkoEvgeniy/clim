@php
    /** @var \CustomForm\Select $dictionarySelect */
    /** @var array $values */
@endphp

@if(!empty($values))
    <div class="additional_specification">
        <div class="gcell gcell--12 _pb-def">
            {!! $dictionarySelect->render() !!}
        </div>
    </div>
@endif
