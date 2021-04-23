<?php
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach($links as $link => $images)
        <url>
            <loc>{{ $link }}</loc>
            @foreach($images as $image)
                <image:image>
                    <image:loc>{{ $image['image'] }}</image:loc>
                    @if(isset($image['alt']))
                        <image:caption>{{ $image['alt'] }}</image:caption>
                    @endif
                    @if(isset($image['title']))
                        <image:title>{{ $image['title'] }}</image:title>
                    @endif
                </image:image>
            @endforeach
        </url>
    @endforeach
</urlset>
