@php
/** @var string $networkName */
/** @var array $item */
@endphp
<div class="gcell gcell--4 _plr-sm">
    <a
            id="social-{{ $networkName }}"
            class="network-link network-link--{{ $networkName }} network-link--{{ $networkName }}-hover network-link--social-login"
            title="{{ $item['text_content'] }}"
            href="{{ route('site.socials.login', ['alias' => $networkName]) }}"
    >
        {!! SiteHelpers\SvgSpritemap::get($item['symbol'], [
            'class' => 'network-link__symbol network-link__symbol--' . $networkName
        ]) !!}
    </a>
</div>
