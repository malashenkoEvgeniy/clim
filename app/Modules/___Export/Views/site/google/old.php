@php
    /** @var \App\Modules\Products\Models\Product[] $offers */
echo '<?xml version="1.0" encoding="utf-8" ?>';
@endphp
<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
    <channel>
        <title>Климатическая техника - купить климатическую технику для дома от интернет магазина вентиляции {{ route('site.home')}}</title>
        <link>{{ route('site.home')}}</link>
        @foreach($offers as $offer)
            <item>
                <g:id>{{ $offer->pg_id }}</g:id>
                <g:title>{{ $offer->title }}</g:title>
                <g:description>
                    <![CDATA[{!! trim(strip_tags(str_replace(array('<o:p>','</o:p>', '&nbsp;', '&','&deg;'),array('','',' ', '&amp;','°'),preg_replace(['/<\!--.+-->/ms','/<table.+<\/table>/ms'], '', $offer->description)))) !!}]]>
                </g:description>
                <g:link>https://{{$_SERVER['HTTP_HOST']}}/products/{{$offer->slug}}</g:link>
                <g:image_link>https://{{$_SERVER['HTTP_HOST']}}/images/cache/medium/{{$offer->img}}</g:image_link>
                <g:availability>{{ $offer->available ? 'in stock' : 'out of stock' }}</g:availability>
                @if($offer->old_price)
                    <g:price>{{$offer->old_price}}</g:price>
                    <g:sale_price>{{$offer->price}}</g:sale_price>
                    <g:sale_price_effective_date>2019-11-29T07:00:00+0200 / 2020-12-02T23:59:00+0200</g:sale_price_effective_date>
                @else
                    <g:price>{{ $offer->price }}</g:price>
                @endif
                <g:condition>new [новый]</g:condition>
                <g:gender>unisex [унисекс]</g:gender>
                <g:brand>{{ str_replace('&', '&amp;',$offer->brand) }}</g:brand>
                <g:custom_label_{{$cl_revers[$category_tree[(int)$offer->category_id]['main']]}}>{{$category_tree[(int)$offer->category_id]['name']}}</g:custom_label_{{$cl_revers[$category_tree[(int)$offer->category_id]['main']]}}>
            </item>
        @endforeach
    </channel>
</rss>
