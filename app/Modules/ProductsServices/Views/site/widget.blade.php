@php
/** @var \App\Modules\ProductsServices\Models\ProductService[] $services */
@endphp

<div class="js-init" data-accordion='{"type":"multiple"}'>
    @foreach($services as $position => $service)
        <div class="_pb-md">
            @include('site._widgets.conditions-item.conditions-item', [
                'icon' => ($service->show_icon && $service->icon) ? $service->icon : null,
                'title' => $service->current->name,
                'url' => route('site.products-services.info-popup', $service->id),
                'descr' => $service->current->description,
                'tabs' => $service->id,
                'isOpen' => !$position,
            ])
        </div>
    @endforeach
</div>
