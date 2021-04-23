<script>
	(function (window) {
		window.LOCO_DATA = {
			modules: {},
			language: '{{ app()->getLocale() }}',
            currency: 'грн.',
            cookie: {
				url: '/data/cookie'
            },
            validation: {
				bySelector: {}
            },
			cart: {
				local: '{{ route('site.ajax-cart') }}'
			},
			google: {
				maps: {
					API_KEY: 'xxx',
					language: '{{ app()->getLocale() }}',
					region: 'ua'
				}
			}
		};
	})(window);
</script>
@if(isset($jsValidator))
    @if(is_array($jsValidator))
        @foreach($jsValidator as $validator)
            {!! $validator !!}
        @endforeach
    @else
        {!! $jsValidator !!}
    @endif
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ site_media('assets/js/bundle-app.js', true) }}"></script>
@stack('scripts')
@if(Auth::guest() || Route::currentRouteNamed('site.account'))
    {{--<script src="{{ site_media('static/js/ulogin.js') }}"></script>--}}
@endif

