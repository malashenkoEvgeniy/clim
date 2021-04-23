<div class="tree">
    @foreach($list as $item)
        <div class="tree__level tree__level--{{ $loop->iteration }}">
            <div class="tree__item tree__item--{{ $loop->iteration }}">
                {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-left-thin', [
                    'class' => 'tree__icon'
                ]) !!}
                <div class="_ellipsis _flex-grow">
                    <a {!! Html::attributes([
                    'class' => 'tree__link',
                    'title' => $item->text_content,
                    'href' => $loop->last ? null : $item->href
                ]) !!}>{{ $item->text_content }}</a>
                </div>
            </div>
    @endforeach
    @foreach($list as $item)
        </div>
    @endforeach
</div>
