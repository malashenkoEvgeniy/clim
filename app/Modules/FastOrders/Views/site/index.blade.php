@php
/** @var int $productId */
@endphp
{!! Form::open(['route' => 'fast-orders-send']) !!}

    <div>

        <div>
            <input type="tel" name="phone" id="callback-tel" data-init="inputmaskMulti"
                   placeholder="{{ __('fast_orders::general.form-phone') }}" required="" data-rule-phoneiscomplete="true">
            <label for="callback-tel">
                {{ __('fast_orders::general.form-phone') }}
            </label>
        </div>

        <div>
            <button type="submit"><span
                    class="button__inner"><span>{{ __('fast_orders::general.form-submit-button') }}</span></span></button>
        </div>
        <input type="hidden" name="product_id" value="1">
    </div>

{!! Form::close() !!}
