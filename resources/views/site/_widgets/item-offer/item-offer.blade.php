<a class="item-offer" href="{{ $slug }}">
    <span class="item-offer__media">
        <img class="item-offer__image" width="40" height="40" alt="{{ $name }}" {!! Html::attributes([
                'src' => $image ? site_media('/temp/product/offers/' . $image) : site_media('/static/images/placeholders/no-image-40x40.png')
            ]) !!}>
    </span>
    <span class="item-offer__name _ellipsis">{{ $name }}</span>
</a>
