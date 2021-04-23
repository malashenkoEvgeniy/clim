<ul>
    @foreach ($tree as $item)
        <li>
            <a {!! array_get($item, 'url') ? 'href="'.$item['url'].'"' : '' !!}><span>{{ $item['name'] }}</span></a>
            @if (!empty($item['items']))
                @include('sitemap::site.recursive', [
                    'tree' => $item['items'],
                ])
            @endif
        </li>
    @endforeach
</ul>
