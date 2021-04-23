@php
/** @var string $h1 */
/** @var boolean $textCenter */
@endphp

<div class="section _mb-def">
    <div class="container">
        <div class="box">
            <h1 class="title title--size-h1 {{ $textCenter ? '_text-center' : '' }}">
                {!! $h1 !!}
            </h1>
        </div>
    </div>
</div>
