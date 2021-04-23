<ol class="breadcrumb">
	@foreach(Seo::breadcrumbs()->elements() AS $breadcrumb)
		@php
		$title = $breadcrumb->getTitle();
		if (Lang::has($title)) {
			$title = __($title);
		}
		@endphp
		@if($breadcrumb->isActive() === false && $breadcrumb->getUrl())
			<li>
				<a href="{{ $breadcrumb->getUrl() }}">
					@if($breadcrumb->getIcon())
						<i class="{{ $breadcrumb->getIcon() }}"></i>
					@endif
					{{ $title }}
				</a>
			</li>
		@else
			<li class="active">
				@if($breadcrumb->getIcon())
					<i class="{{ $breadcrumb->getIcon() }}"></i>
				@endif
				{{ $title }}
			</li>
		@endif
	@endforeach
</ol>
