@php
    /** @var \App\Modules\Products\Models\Product[] $offers */
echo '<?xml version="1.0" encoding="utf-8" ?>';
@endphp
<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
    <channel>
        <title>Климатическая техника - купить климатическую технику для дома от интернет магазина вентиляции {{ route('site.home')}}</title>
        <link>{{ route('site.home')}}</link>
        @foreach($offers as $offer)
            @if ($offer->pg_id == 644)
                @php
                    continue;
                @endphp
            @endif
            <item>
                <g:id>{{ $offer->pg_id }}</g:id>
                <g:title>{{ $offer->title }}</g:title>
                <g:description>
                    {!!
                    trim(strip_tags(str_replace(array('<o:p>','</o:p>', '&nbsp;', '&','&deg;'),array('','',' ', '&amp;','°'),preg_replace(['/<\!--.+-->/ms','/<table.+<\/table>/ms'], '', $offer->description))))
                     !!}
                </g:description>
                <g:link>https://{{$_SERVER['HTTP_HOST']}}/products/{{$offer->slug}}</g:link>
                <g:image_link>https://{{$_SERVER['HTTP_HOST']}}/images/cache/medium/{{$offer->img}}</g:image_link>
                <g:availability>{{ $offer->available ? 'in stock' : 'out of stock' }}</g:availability>
                <g:price>{{ $offer->price." UAH" }}</g:price>
                <g:condition>new</g:condition>
                <g:gender>unisex</g:gender>
                <g:brand>{{ str_replace('&', '&amp;',$offer->brand) }}</g:brand>
                <g:product_type >{{$category_tree[(int)$offer->category_id]['name']}}</g:product_type >
                <g:mpn>{{ $offer->pg_id }}</g:mpn>
            </item>
        @endforeach
    </channel>
</rss>
