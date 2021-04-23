@php
    $as_form = isset($form) && $form;
    $options = [
        'expires' => date('Y-m-d', strtotime('2019-01-01')), // @TODO заменить на норм дату
        'path' => '/'
    ];

    // $itemShow = (object)[
    //     'key' =>
    // ]
@endphp

<div>
    @if($as_form)
        <form class="grid _justify-between" action="{{ $action ?? null }}">
    @else
        <div class="grid _nmtb-xs _justify-between">
    @endif
            <div class="gcell _mtb-xxs">
                <input type="hidden" name="query" value="{{ $query_value ?? null }}">
                <div class="inline-control">
                    <label for="#sort-control" class="inline-control__label">
                        Сортировать:
                    </label>
                    <div class="inline-control__element">
                        <select id="sort-control"
                                name="sort"
                                class="select js-sort-control">
                            <option value="1">от дешевых к дорогим</option>
                            <option value="2">от дорогих к дешевым</option>
                            <option value="3">по названию от А до Я</option>
                            <option value="4">по названию от Я до А</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="gcell _mtb-xxs">
                <div class="inline-control">
                    <label for="#show-control" class="inline-control__label">
                        Товаров на странице:
                    </label>
                    <div class="inline-control__element">
                        <select id="sort-control"
                                name="show"
                                class="select js-sort-control"
                                data-cookie-key="items-show"
                                data-cookie-options='{!! json_encode($options) !!}'>
                            <option value="16">16</option>
                            <option value="44">44</option>
                            <option value="92">92</option>
                            <option value="1000">все</option>
                        </select>
                    </div>
                </div>
            </div>
    @if($as_form)
        </form>
    @else
        </div>
    @endif
</div>
