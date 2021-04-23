@extends('site._layouts.main')

{{-- TODO Убрать и передавать значения с контроллера --}}
@push('viewTitle', 'Отзывы')
{{-- ENDTODO Убрать и передавать значения с контроллера --}}

@section('layout-breadcrumbs')
    <div class="section">
        <div class="container">
            @include('site._widgets.breadcrumbs.breadcrumbs', ['list' => [
                config('mock.nav-links.index'),
                config('mock.nav-links.reviews')
            ]])
        </div>
    </div>
@endsection

@section('layout-body')
    <div class="section">
        <div class="container">
            <div class="box box--gap">
                <div class="title title--size-h1">Отзывы</div>
            </div>
            <div class="box box--gap _plr-def _ptb-xs _def-plr-lg _def-ptb-md">
                <div class="grid _nm-md _def-nm-def">
                    @foreach(config('mock.gallery') as $item)
                        <div class="gcell gcell--12 gcell--ms-6 gcell--lg-4 _p-md _def-p-def">
                            @component('site._widgets.reviews-item.reviews-item', [
                            'mod_class' => 'reviews-item--theme-dark',
                            'mod_message_class' => 'reviews-item-message--def',
                            'user_name' => 'Татьяна Иванова',
                            'user_about' => 'частный предприниматель'
                        ])
                                Спасибо «Locotradeпромпостач» за качественную ветеринарную продукцию. Профилактику и
                                лечение
                                животных провожу только с помощью ваших консультаций и препаратов.
                                Да если бы не вы, все мое большое рогатое хозяйство давно бы наверное обанкротилось.
                                Буду
                                надеяться о сотрудничестве в том же духе
                            @endcomponent
                        </div>
                    @endforeach
                </div>
                @include('site._widgets.pagination.pagination', ['show_all' => false])
                <hr class="separator _color-white _mtb-def">
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="box box--gap">
                <div class="container container--md">
                    <div class="title title--size-h2 _text-center">Оставить отзыв</div>
                    @include('site._widgets.forms.reviews')
                </div>
            </div>
        </div>
    </div>
@endsection
