<div class="item-card-title">
    <div class="item-card-title__dfn">{{ $dfn ?? '' }}</div>
    <div>
        <a href="{{ isset($href) ? 'href="' . $href . '"' : '' }}"
                class="item-card-title__text">
            {{ $text_content }}
        </a>
    </div>
</div>
