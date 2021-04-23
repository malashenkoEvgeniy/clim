@php
@endphp

@if(isset($slot) && trim(strip_tags($slot)))
    @if(Auth::guest())
        <div class="section _mtb-lg">
            <div class="container">
                {{ $slot }}
            </div>
        </div>
    @else
        <div class="account account--wishlist">
            {{ $slot }}
        </div>
    @endif
@endif
