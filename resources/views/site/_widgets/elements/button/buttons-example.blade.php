<div>
    @php
    	$themes = [
    	    'theme-default',
    	    'theme-main'
    	];
    @endphp
    @foreach($themes as $theme)
        <p><em>{{ $theme }}</em></p>

        <button class="button button--{{ $theme }} button--size-normal">
        <span class="button__body">
            <span class="button__text">Lorem ipsum dolor sit amet</span>
        </span>
        </button>

        <button class="button button--{{ $theme }} button--size-normal">
        <span class="button__body">
            {!! SiteHelpers\SvgSpritemap::get('icon-bell', [
                'class' => 'button__icon button__icon--before'
            ]) !!}
            <span class="button__text">Иконка слева</span>
        </span>
        </button>

        <button class="button button--{{ $theme }} button--size-normal">
        <span class="button__body">
            {!! SiteHelpers\SvgSpritemap::get('icon-bell', [
                'class' => 'button__icon button__icon--after'
            ]) !!}
            <span class="button__text">Иконка справа</span>
        </span>
        </button>

        <button class="button button--{{ $theme }} button--size-normal">
        <span class="button__body">
            {!! SiteHelpers\SvgSpritemap::get('icon-bell', [
                'class' => 'button__icon'
            ]) !!}
        </span>
        </button>
    @endforeach
</div>
