<div class="header-over">
    <div class="header-over__right">
        <div class="header-line-item">
            <a class="header-line-item__link header-line-item__link--current">RU</a>
            <a class="header-line-item__link" href="#">UA</a>
        </div>
        <div class="header-line-item">
            <a class="header-line-item__link header-line-item__link--icon" href="{{ route('site.profile-view') }}">
                {!! SiteHelpers\SvgSpritemap::get('icon-user') !!}
                <span>Вход в личный кабинет</span>
            </a>
        </div>
    </div>
    <div class="header-over__left">
        <div class="header-line">
            <div class="header-line__list">

                {{-- TODO убрать ссылку на ui-kit --}}
                <div class="header-line-item">
                    <a class="header-line-item__link" href="{{ config('mock.nav-links.ui')->href }}">
                        {{ config('mock.nav-links.ui')->text_content }}
                    </a>
                </div>
                {{-- ENDTODO убрать ссылку на ui-kit --}}

                @foreach($list as $item)
                    <div class="header-line-item">
                        <a class="header-line-item__link" href="{{ $item->href }}">
                            {{ $item->text_content }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
