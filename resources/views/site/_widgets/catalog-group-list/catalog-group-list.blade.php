<div class="grid grid--2 grid--ms-3 grid--def-4 grid--lg-5">
    @foreach($list as $group)
        <div class="gcell">
            <div class="catalog-group">
                <div class="catalog-group__image">
                    <a href="{{ $group->href }}" title="{{ $group->text_content }}">
                        <img src="{{ site_media('temp/catalog-groups/' . $group->thumb) }}"
                                alt=" {{ $group->text_content }}"
                                width="260"
                                height="200">
                    </a>
                </div>
                <div class="catalog-group__title">
                    <div class="title title--size-h3">
                        <a href="{{ $group->href }}">
                            {{ $group->text_content }}
                        </a>
                    </div>
                </div>
                <div class="catalog-group__inner">
                    @foreach($group->inner as $index => $inner)
                        <div class="catalog-group__item">
                            <a href="{{ $inner->href }}"
                                    class="catalog-group__link"
                                    title="{{ $inner->text_content }}">
                                {{ $inner->text_content }}
                            </a>
                        </div>
                        @if($index === 5)
                            <div class="catalog-group__item">
                                <a href="#" class="catalog-group__link catalog-group__link--all">
                                    Показать все
                                </a>
                            </div>
                            @break
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
