@php
    /** @var \CustomForm\Select $dictionarySelect */
    /** @var array $values */
@endphp

@if(!empty($values))
    <div class="grid _items-center _justify-center _def-justify-start _mb-def _nml-sm">
        <div class="gcell _pl-sm">
            <form onsubmit="event.preventDefault()">
                {!! $dictionarySelect->render() !!}
            </form>
        </div>
    </div>
@endif
