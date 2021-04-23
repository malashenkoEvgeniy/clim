<div class="section _bgcolor-gray2">
    <div class="container _ptb-xl">
        <article class="wysiwyg">
            @if(isset($h1))
                <h1>{{ $h1 }}</h1>
            @endif
            <div class="scroll-text scroll-text--article _color-gray2">
                <div class="scroll-text__content wysiwyg _color-gray6 js-init"
                        data-wrap-media
                        data-prismjs
                        data-draggable-table
                        data-perfect-scrollbar>
                        <!--seotext_ph_start-->
                    {{ $slot }}
                        <!--seotext_ph_end-->
                </div>
            </div>
        </article>
    </div>
</div>
