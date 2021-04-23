<div class="particle js-init {{ $frameColor ?? '' }}" data-particle
        style="max-width: {{ $width }}px;">
    <img class="particle__img"
        data-particle-source="{{ $drawSource ?? $source }}"
        src="{{ $source }}"
        width="{{ $width }}"
        height="{{ $height }}"
        alt="">
    <canvas class="particle__canvas"
        data-particle-canvas
        width="{{ $width }}"
        height="{{ $height }}"></canvas>
    <div class="particle__frame"></div>
</div>
{{--<div class="js-init" data-particle>
    <img data-particle-source src="{{ site_media('temp/flasks--particles.png') }}" alt="">
    <canvas data-particle-canvas width="670" height="670"></canvas>
</div>--}}
{{--<div class="main-animation main-animation--flasks">
    <div class="main-animation__inner">
       <div class="main-animation__slide js-particle" id="particle-slider">
            <div class="slides">
                <div class="slide" data-src="/temp/flasks--particles.png"></div>
            </div>
            <canvas class="draw"></canvas>
        </div>
        <div class="main-animation__bg"></div>
    </div>
</div>--}}
