@php
	$options = [
		'expires' => 2147483647,
		'path' => '/'
	];
@endphp
<div class="cookie-info"
		data-cookie-info
		data-cookie-options='{!! json_encode($options) !!}'
		style="display: none;">
	<div class="container">
		<div class="grid _nm-sm _md-flex-nowrap _items-center">
			<div class="gcell _flex-grow _p-sm">
				<p class="cookie-info__content">
					{{ __('cookie.message') }}
				</p>
			</div>
			<div class="gcell _flex-noshrink _flex-grow _p-sm">
				<div class="grid _justify-center">
					<div class="gcell">
						<form data-cookie-form>
							<input class="checker__input" type="hidden" name="allow-cookie-usage" value="true">
							<button type="submit" class="button button--theme-default-invert button--size-small">
                                <span class="button__body">
                                    {!! SiteHelpers\SvgSpritemap::get('icon-ok', [
                                        'class' => 'button__icon button__icon--before'
                                    ]) !!}
	                                <span class="button__text">{{ __('cookie.button') }}</span>
                                </span>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
