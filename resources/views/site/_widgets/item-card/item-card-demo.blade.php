<div class="grid grid--5">
    @for($i = 0; $i < $count; $i++)
        <div class="gcell">
            @include('site._widgets.item-card.item-card')
        </div>
        <div class="gcell">
            @include('site._widgets.item-card.item-card')
        </div>
        <div class="gcell">
            @include('site._widgets.item-card.item-card')
        </div>
        <div class="gcell">
            @include('site._widgets.item-card.item-card')
        </div>
        <div class="gcell">
            @include('site._widgets.item-card.item-card')
        </div>
    @endfor
</div>
