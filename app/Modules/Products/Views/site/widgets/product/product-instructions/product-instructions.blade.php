@php
/** @var string $text */
@endphp
<article class="wysiwyg">
    <div class="scroll-text">
        <div class="scroll-text__content wysiwyg js-init"
            data-wrap-media
            data-prismjs
            data-draggable-table
            data-perfect-scrollbar
            data-mfp
        >
            {!! $text !!}
        </div>
    </div>
</article>
