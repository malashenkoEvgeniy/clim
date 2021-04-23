@php
/** @var \App\Modules\News\Models\News $news */
/** @var string|null $logo */
@endphp
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "NewsArticle",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ $news->link }}"
    },
    "headline": "{{ $news->current->name }}",
    @if($news->image && $news->image->isImageExists())
    "image": [
        "{{ $news->image->link() }}"
    ],
    @endif
    "datePublished": "{{ $news->published_at }}",
    "dateModified": "{{ $news->updated_at ?: $news->published_at }}",
    "author": {
        "@type": "Organization",
        "name": "{{ env('APP_NAME') }}"
    },
    "publisher": {
        "@type": "Organization",
        "name": "{{ env('APP_NAME') }}",
        @if(isset($logo) && $logo)
        "logo": {
            "@type": "ImageObject",
            "url": "{{ $logo }}}"
        }
        @endif
    },
    "description": "{{ $news->teaser }}"
}
</script>
