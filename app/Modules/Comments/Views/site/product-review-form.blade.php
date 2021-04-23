@php
/** @var string $type */
/** @var int $productId */
$authUser = \Auth::user();
@endphp
@push('hidden_data')
    {!! $validation !!}
@endpush
<div class="container container--md">
    <div class="form" id="review-form">
        {!! Form::open(['id' => $formId, 'route' => 'site.comments.create', 'class' => ['js-init', 'ajax-form']]) !!}
            {!! Form::input('hidden', 'commentable_type', $type) !!}
            {!! Form::input('hidden', 'commentable_id', $productId) !!}
            <div class="form__body">
                <div class="grid">
                    <div class="gcell gcell--12 _pt-sm _pb-lg _sm-plr-lg">
                        <div class="grid">
                            <div class="gcell gcell--12 _pb-md">
                                <div class="control control--textarea">
                                    <div class="control__inner">
                                    <textarea class="control__field" name="comment"
                                              id="review-message" required></textarea>
                                        <label class="control__label" for="review-message">Комментарий *</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid _nml-md _nmt-md _pb-md">
                            <div class="gcell gcell--12 gcell--ms-6 _pl-md _pt-md">
                                <div class="control control--input{{ $authUser != null && $authUser->name ? ' has-value' : null }}">
                                    <div class="control__inner">
                                        <input class="control__field" type="text" name="name"
                                               @if($authUser ?? null)
                                                    value="{{$authUser->name}}"
                                               @endif
                                               id="review-name" required>
                                        <label class="control__label" for="review-name">Ваше имя *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 gcell--ms-6 _pl-md _pt-md">
                                <div class="control control--input{{ $authUser != null && $authUser->name ? ' has-value' : null }}">
                                    <div class="control__inner">
                                        <input class="control__field" type="email"
                                               @if($authUser ?? null)
                                                 value="{{$authUser->email}}"
                                               @endif
                                               name="email"
                                               id="review-email">
                                        <label class="control__label" for="review-email">Эл. почта *</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid _justify-center _pt-md">
                            <div class="gcell">
                                @include('site._widgets.star-choose.star-choose', [
                                    'input_name' => 'mark',
                                ])
                            </div>
                        </div>
                    </div>
                    <div class="gcell gcell--12 _sm-plr-lg">
                        <div class="gcell gcell--12 _pt-lg _pb-sm">
                            @component('site._widgets.checker.checker', [
                                'attributes' => [
                                    'type' => 'checkbox',
                                    'name' => 'personal-data-processing',
                                    'required' => true,
                                ],
                            ])
                                @lang('callback::site.agreement') →
                                <a href="{{ config('db.basic.agreement_link') }}"
                                   target="_blank">@lang('global.more')</a>
                                <label id="personal-data-processing-error" class="has-error"
                                       for="personal-data-processing" style="display: none;"></label>
                            @endcomponent
                        </div>
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
</div>
