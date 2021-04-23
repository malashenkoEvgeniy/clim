<div class="category__items grid grid--2 grid--xs-4 grid--md-5 grid--def-5 grid--xl-5">
    @foreach($categories as $category)
        <div class="category__item gcell _text-center _p-sm">
            <div class="category__item__thumb">
                <a href="{{ $category->site_link }}">
                    @if ($category->image && $category->image->exists && $category->image->isimageExists())
                        {!! $category->image->imageTag('small', ['width' => 320, 'height' => 240, 'alt' => $category->current->name]) !!}
                    @endif
                </a>
            </div>
            @if($category->current->slug === $currentCategorySlug)
                <span class="category__item__title item-card-title__text is-disabled">{{ $category->current->name }}</span>
            @else
                <a href="{{ $category->site_link }}" class="category__item__title item-card-title__text">{{ $category->current->name }}</a>
            @endif

        </div>
    @endforeach
</div>