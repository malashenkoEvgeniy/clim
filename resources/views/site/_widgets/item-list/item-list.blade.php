@php
	$classes = 'grid--2 grid--xs-3 grid--md-4 grid--def-3 grid--lg-4';
    if (isset($full_width) && $full_width) {
        $classes = 'grid--2 grid--xs-3 grid--md-4 grid--lg-5';
    }
@endphp
<div class="item-list">
    <div class="grid {{ $classes }}">
        @for($i = 0; $i < 5; $i++)
            @foreach($list as $item)
                <div class="gcell">
                    @include('site._widgets.item-card.item-card', [
                        'item' => $item
                    ])
                </div>
            @endforeach
        @endfor
    </div>
</div>
