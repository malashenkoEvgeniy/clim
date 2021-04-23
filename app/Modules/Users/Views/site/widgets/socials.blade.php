@php
/** @var string $route */
/** @var string $fields */
/** @var string $hidden */
/** @var \Illuminate\Support\Collection|\App\Modules\Users\Models\UserNetwork[] $networks */

@endphp
@foreach(config('users.socials') as $networkName => $item)
    @if(isset($checkSocials[$networkName]))
        @include('users::site.widgets.social-network', [
            'item' => $item,
            'networkName' => $networkName,
        ])
    @endif
@endforeach
