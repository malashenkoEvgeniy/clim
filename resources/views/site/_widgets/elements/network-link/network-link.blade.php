<a class="network-link network-link--{{ $network }}"
        href="{{ $item->href }}"
        title="{{ $item->text_content }}">
    {!! SiteHelpers\SvgSpritemap::get($item->symbol, [
        'class' => 'network-link__symbol network-link__symbol--' . $network
    ]) !!}
</a>
