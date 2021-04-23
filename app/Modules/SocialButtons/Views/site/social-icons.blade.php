@foreach($icons as $key => $link)
    @if(!empty($link))
        <div class="fixed-menu__item">
            <a rel="nofollow" target="_blank" class="network-link network-link--{{ $key }}"
                    href="{{ $link }}"
                    title="{{ $labels[$key] ?? null }}">
                {!! SiteHelpers\SvgSpritemap::get('icon-network-'.$key, [
                    'class' => 'network-link__symbol network-link__symbol--' . $key
                ]) !!}
            </a>
        </div>
    @endif
@endforeach