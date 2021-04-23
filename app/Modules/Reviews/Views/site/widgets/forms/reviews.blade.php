@php
$email = Auth::user() ? Auth::user()->email : null;
$name = Auth::user() ? Auth::user()->name : null;
@endphp

<div class="form">
   {!! Form::open(['route' => 'review-send', 'files' => true, 'id' => 'review-form', 'class' => ['js-init', 'ajax-form']]) !!}
        <div class="form__body">
            <div class="grid">
                <div class="gcell gcell--12 _pt-sm _pb-lg _sm-plr-lg">
                    <div class="grid _nml-md _nmt-md _pb-md">
                        <div class="gcell gcell--12 gcell--ms-6 _pl-md _pt-md">
                            <div class="control control--input {{ $name ? 'has-value' : null }}">
                                <div class="control__inner">
                                    <input class="control__field" type="text" name="name" id="review-name" value="{{ $name }}" required>
                                    <label class="control__label" for="review-name">Имя *</label>
                                </div>
                            </div>
                        </div>
                        <div class="gcell gcell--12 gcell--ms-6 _pl-md _pt-md">
                            <div class="control control--input {{ $email ? 'has-value' : null }}">
                                <div class="control__inner">
                                    <input class="control__field" type="email" name="email" value="{{ $email }}"
                                           id="review-email">
                                    <label class="control__label" for="review-email">Эл. почта</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid">
                        <div class="gcell gcell--12 _pb-md">
                            <div class="control control--textarea">
                                <div class="control__inner">
                                    <textarea class="control__field" name="comment"
                                              id="review-message" required></textarea>
                                    <label class="control__label" for="review-message">Ваше сообщение *</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gcell gcell--12 _sm-plr-lg">
                    @component('site._widgets.checker.checker', [
                        'attributes' => [
                            'type' => 'checkbox',
                            'name' => 'personal-data-processing',
                            'required' => true,
                        ]
                    ])
                        Я согласен на обработку моих данных.<br><a href="{{ config('db.basic.agreement_link') }}" target="_blank">Подробнее</a>
                    @endcomponent
                </div>
                <div class="gcell gcell--12 _sm-plr-lg">
                    <div class="grid _justify-center">
                        <div class="gcell _pt-lg _pb-sm">
                            <div class="control control--submit">
                                <button class="button button--theme-main button--size-normal"
                                        type="submit">
                                        <span class="button__body">
                                            <span class="button__text">Отправить отзыв</span>
                                        </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>
