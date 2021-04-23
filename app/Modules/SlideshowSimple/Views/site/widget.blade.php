@php
/** @var \App\Modules\SlideshowSimple\Models\SlideshowSimple[]|\Illuminate\Database\Eloquent\Collection $slides */
@endphp
<div class="section">
    <div class="container">
        <div class="action-bar">
            @if(browserizr()->isDesktop())
                <div class="action-bar__side _lg-show"></div>
            @endif
            <div class="action-bar__wide">
                <div>
                    @include('slideshow_simple::site.action-bar-slider.action-bar-slider', [
                        'slides' => $slides,
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
