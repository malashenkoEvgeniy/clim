@php
/** @var \App\Modules\Products\Models\Product $product */
/** @var int $index */
@endphp
<div class="modification-images">
    @foreach($product->images as $image)
        @if($image->isImageExists())
            <div class="file-attach recently-uploaded" data-id="{{ $image->id }}">
                <a
                    href="{{ route('admin.products.delete-image', $image->id) }}"
                    class="delete-remote-modification-image ajax-request"
                    data-confirmation="@lang('products::admin.image-on-server-delete-warning')"
                >
                    <i class="fa fa-close"></i>
                </a>
                <a
                    class="label"
                    data-lightbox="product-{{ $product->id }}"
                    style="background-image: url({{ $image->link('small') }}); cursor:zoom-in;"
                    href="{{ $image->link() }}"
                ></a>
            </div>
        @endif
    @endforeach
</div>
<div class="clearfix"></div>
<button class="btn btn-flat add-modification-image" type="button">@lang('products::admin.add-image')</button>
