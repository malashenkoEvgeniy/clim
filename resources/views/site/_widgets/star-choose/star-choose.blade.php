<div class="star-choose">
    <div class="star-choose__inner">
        @for ($i = 5; $i > 0; $i--)
            <input type="radio" class="star-choose__input" name="{{ $input_name }}" id="{{ $input_name . $i }}" value="{{ $i }}">
            <div class="star-choose__svg-holder">
                {!! SiteHelpers\SvgSpritemap::get('icon-star-full', [
                    'class' => 'star-choose__svg'
                ]) !!}
            </div>
        @endfor
    </div>
</div>
