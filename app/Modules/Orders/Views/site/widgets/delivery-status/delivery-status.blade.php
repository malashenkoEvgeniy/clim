<!-- TODO переверстать -->
<div id="popup-one-click-buy" class="popup popup--one-click-buy" style="max-width:50em;">
    <div class="popup__container">
        <div class="popup-css delivery-status-popup">
            <div name="content">
                <div>
                    <h2>@lang('orders::site.delivery.status')</h2>
                    <div>
                        <a class="js-init" data-mfp="ajax" data-mfp-src="{{ $link }}"
                           href="#">@lang('orders::site.delivery.refresh')</a>
                    </div>
                </div>
                <div>
                    <div>
                        @if($delivery['date'] ?? null)
                            <div>{{$delivery['date']}}</div>
                            <hr>
                        @endif
                        <div class="clearfix">
                            <div class="clearfix">
                                @if($delivery['time'] ?? null)
                                    <span>{{$delivery['time']}}</span>
                                @endif
                                <span>
                                    @if($delivery['citySender'] ?? null)
                                        <span>{{$delivery['citySender']}}, </span>
                                    @endif
                                    @if($delivery['cityRecipient'] ?? null)
                                        <span>{{$delivery['cityRecipient']}}</span>
                                    @endif
                                </span>
                                <span>
                                    @if($delivery['status'] ?? null)
                                        <span> - {{$delivery['status']}}</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <h3> @lang('orders::site.delivery.information') </h3>
                @if($delivery['ttn'] ?? null)
                    <div class="clearfix">
                        <span>@lang('orders::site.delivery.number') : </span>
                        <span>{{$delivery['ttn']}}</span>
                    </div>
                @endif
                @if($delivery['citySender'] ?? null || $delivery['cityRecipient'] ?? null)
                    <div class="clearfix">
                        <span> @lang('orders::site.delivery.route') : </span>
                        @if($delivery['citySender'] ?? null)
                            <span> {{$delivery['citySender']}} - </span>
                        @endif
                        @if($delivery['cityRecipient'] ?? null)
                            <span> {{$delivery['cityRecipient']}} </span>
                        @endif
                    </div>
                @endif
                @if($delivery['warehouseRecipient'] ?? null)
                    <div class="clearfix">
                        <span> @lang('orders::site.delivery.address') : </span>
                        <span> {{$delivery['warehouseRecipient']}}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>