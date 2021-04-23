@php
    /** @var \App\Components\Filter\FilterBlock $block */
@endphp
<hr class="separator _color-gray2 _mtb-md">
@component('products::site.widgets.filter-accordion.accordion-block', [
    'ns' => 'filter',
    'id' => $block->alias,
    'header' => __($block->name),
    'open' => $block->isOpen(),
])
    @foreach($block->getElements() as $element)
        @if($element->showInFilter())
            <div class="_mb-sm _color-black">
                @component('products::site.widgets.accordion.checker.checker', [
                    'attributes' => [
                        'type' => 'checkbox',
                        'name' => $block->alias,
                        'checked' => $element->selected,
                        'value' => $element->alias,
                    ],
                    'href' => $element->link(),
                    'filter_name' => $element->name,
                    'header' => __($block->name),
                    'disabled' => $element->disabled(),
                    'checked' => $element->selected
                ])
                    {{ $element->name }} <span class="checker__counter">{{ $element->filteredCountToShow() }}</span>
                @endcomponent
            </div>
        @endif
    @endforeach
@endcomponent
