@php
/** @var string $networkName */
/** @var string $symbol */
/** @var \App\Modules\Users\Models\UserNetwork $network */
@endphp
<div class="gcell gcell--4 _plr-sm">
    <a
        href="{{ $network->link }}"
        target="_blank"
        style="opacity: 0.3;"
        id="social-{{ $networkName }}"
        class="network-link network-link--{{ $networkName }} added network-link--{{ $networkName }}-hover network-link--social-login"
        title="{{ $network->email }}"
    >
        {!! SiteHelpers\SvgSpritemap::get($item['symbol'], [
            'class' => 'network-link__symbol network-link__symbol--' . $networkName
        ]) !!}
    </a>
</div>