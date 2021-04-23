<div class="item-card">
    <div class="item-card__head">
        @include('site._widgets.item-card.item-card-preview.item-card-preview', [
            'src' => site_media('temp/item-card/' . $item->image, true),
            'href' => $item->href,
            'title' => $item->title
        ])
        @if($item->badge)
            <div class="item-card__badges">
                @include('site._widgets.item-badge.item-badge', [
                    'type' => $item->badge->type,
                    'text' => $item->badge->text
                ])
            </div>
        @endif
    </div>
    <div class="item-card__body">
        @include('site._widgets.item-card.item-card-title.item-card-title', [
            'dfn' => $item->code ?? 've-20122',
            'href' => $item->href,
            'text_content' => $item->title
        ])
    </div>
    <div class="item-card__foot">
        @include('site._widgets.item-card.item-card-price.item-card-price', [
            'old_value' => $item->old_price ?? '124.55',
            'value' => $item->price ?? '87.60'
        ])
        @include('site._widgets.item-card.item-card-controls.item-card-controls')
    </div>
    <div class="item-card__desc">
        @include('site._widgets.item-card.item-card-desc.item-card-desc')
    </div>
</div>
