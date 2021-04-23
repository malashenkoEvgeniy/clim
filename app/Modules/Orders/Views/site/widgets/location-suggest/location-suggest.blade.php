<ul class="location-suggest">
    @if(!empty($locations))
        @foreach($locations as $location)
            <li class="location-suggest__item" data-suggest-item data-location-id="{{ $location['DeliveryCity'] }}">{{ $location['Present'] }}</li>
        @endforeach
    @else
        <li class="location-suggest__item" style="pointer-events: none; opacity: .5;">Ничего не найдено</li>
    @endif
</ul>
