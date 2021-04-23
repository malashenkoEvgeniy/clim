@php
$h1 = Seo::meta()->getH1();
if (Lang::has($h1)) {
	$h1 = __($h1);
}
@endphp

<section class="content-header">
	<h1>@yield('h1', $h1)</h1>
    @if(Seo::breadcrumbs()->needsToBeDisplayed())
		@include('admin.widgets.breadcrumbs')
	@endif
	<div class="text-right clearfix">{!! Widget::position('header-buttons')!!}</div>
</section>
