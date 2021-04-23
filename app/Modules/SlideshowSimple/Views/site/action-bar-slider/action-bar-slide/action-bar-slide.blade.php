@php
/** @var \App\Modules\SlideshowSimple\Models\SlideshowSimple $slide */
$image = $slide->image;
@endphp

<div class="slick-slider-list__item">
    <div class="action-bar-slide" style="{{ $image ? 'background-image:url(' . $image->link('big') . ');' : ''}}">
        <div class="action-bar-slide__holder">
            <div class="action-bar-slide__slide">
                <div class="action-bar-slide__lines"></div>
                <div class="action-bar-slide__image"></div>
                @if($slide->url)
                    <div class="action-bar-slide__link">
                        <a href="{{ $slide->url }}" class="button button--theme-main button--size-normal">
                            <span class="button__body">
                                {!! SiteHelpers\SvgSpritemap::get('icon-arrow-right-thin', [
                                    'class' => 'button__icon button__icon--after'
                                ]) !!}
                                <span class="button__text">@lang('slideshow_simple::site.more')</span>
                            </span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
