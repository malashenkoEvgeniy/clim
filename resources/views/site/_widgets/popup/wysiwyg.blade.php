<div class="popup popup--wysiwyg">
    <div class="popup__container">
        <div class="popup__head">
            <div class="grid _flex-nowrap">
                <div class="gcell gcell--auto _flex-grow">
                    <div class="popup__title">{{ $title ?? '' }}</div>
                </div>
            </div>
        </div>
        <div class="popup__body">
            <div class="wysiwyg js-init"
                data-wrap-media
                data-prismjs
                data-draggable-table
                data-perfect-scrollbar>
                {!! $text ?? '' !!}
            </div>
        </div>
    </div>
</div>

