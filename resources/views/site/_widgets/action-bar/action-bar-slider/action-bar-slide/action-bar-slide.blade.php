<div class="action-bar-slide" style="background-image:url({{ site_media($bg, true) }});">
    <div class="action-bar-slide__holder">
        <div class="action-bar-slide__slide">
            <div class="action-bar-slide__lines">
                @foreach($lines as $line)
                    <div>{{ $line }}</div>
                @endforeach
            </div>

            <div class="action-bar-slide__image">
                {{-- @TODO размер изображений 700x400 --}}
                <img width="700" height="400"
                        src="{{ site_media($image, true) }}"
                        alt="{{ implode(' ', $lines) }}">
            </div>

            <div class="action-bar-slide__link">
                <a href="{{ $href }}" class="button button--theme-default-invert button--size-normal">
                    <span class="button__body">
                        {!! SiteHelpers\SvgSpritemap::get('icon-arrow-right-thin', [
                            'class' => 'button__icon button__icon--after'
                        ]) !!}
                        <span class="button__text">ПОДРОБНЕЕ</span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
