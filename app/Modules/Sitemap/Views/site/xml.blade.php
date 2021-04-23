<?php
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($links as $link)
        @if(isset($link['url']))
        <url>
            <loc>{{ $link['url'] }}</loc>
        </url>
        @endif
    @endforeach
</urlset>
