<div class="phone-number{{ (isset($help_classes) ? ' ' . $help_classes : '') }}">
    <div class="_ellipsis">
        <a class="phone-number__link{{ (isset($link_mod_classes) ? ' ' . $link_mod_classes : '') }}"
                title="{{ $phone->text_content }}"
                href="tel:{{ $phone->href }}">
            {{ $phone->text_content }}
        </a>
    </div>
    @if(isset($show_description) AND $show_description)
        <p class="phone-number__description">{{ $phone->description }}</p>
    @endif
</div>
