<ul class="nav-links{{ (isset($list_mod_classes) ? ' ' . $list_mod_classes : '') }}">
    @foreach($list as $link)
        <li class="nav-links__item">
            <a class="nav-links__link" href="{{ $link->href }}">{{ $link->text_content }}</a>
        </li>
    @endforeach
</ul>
