@php
/** @var \App\Modules\Articles\Models\Article $article */
/** @var string|null $logo */
@endphp
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "NewsArticle",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ $article->link }}"
    },
    "headline": "{{ $article->current->name }}",
    @if($article->image && $article->image->isImageExists())
    "image": [
        "{{ $article->image->link() }}"
    ],
    @endif
    "datePublished": "{{ $article->created_at }}",
    "dateModified": "{{ $article->updated_at ?: $article->created_at }}",
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
    "description": "{{ $article->teaser }}"
}
</script>
