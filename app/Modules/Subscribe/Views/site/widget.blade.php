@push('hidden_data')
    {!! $validation !!}
@endpush

<div class="section _bgcolor-main _ptb-def">
    <div class="container">
        {!! Form::open(['route' => 'site.subscribe', 'class' => ['js-init', 'ajax-form'], 'id' => $formId, 'autocomplete' => 'off']) !!}
            <div class="form__body">
                <div class="grid _nm-def _items-center _justify-center">
                    <div class="gcell gcell--def-4 _p-def">
                        <div class="grid _items-center _flex-nowrap _nml-def">
                            <div class="gcell _pl-def">
                                {!! SiteHelpers\SvgSpritemap::get('icon-mail', [
                                    'class' => '_fill-white',
                                    'style' => 'width: 2rem; height: 2rem',
                                ]) !!}
                            </div>
                            <div class="gcell _pl-def">
                                <div class="_color-white">
                                    <b class="text text--size-18">Подписывайтесь</b> на скидки и рекомендации:
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gcell gcell--12 gcell--def-8 _p-def">
                        <div class="grid _nm-md _items-center _ms-flex-nowrap">
                            <div class="gcell gcell--12 gcell--ms-auto _flex-grow _p-md">
                                <div class="control control--input control--white {{ $name ? 'has-value' : null }}">
                                    <div class="control__inner">
                                        <input class="control__field" type="text" name="name" id="subscribe-name" value="{{ $name }}">
                                        <label class="control__label" for="subscribe-name">Имя</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 gcell--ms-auto _flex-grow _p-md">
                                <div class="control control--input control--white {{ $email ? 'has-value' : null }}">
                                    <div class="control__inner">
                                        <input class="control__field" type="email" name="email"
                                               id="subscribe-email" required value="{{ $email }}">
                                        <label class="control__label" for="subscribe-email">Эл. почта *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 gcell--ms-auto _flex-noshrink _p-md _self-end">
                                <div class="grid _justify-center">
                                    <div class="gcell">
                                        <div class="control control--submit">
                                            <button class="button button--theme-white button--size-normal" type="submit" animation-button>
                                                <span class="button__load"><i></i><i></i><i></i></span>
                                                <span class="button__body">
                                                    <span class="button__text">Подписаться</span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
