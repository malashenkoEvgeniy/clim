<?php
/** @var \App\Components\Menu\Block $element */
/** @var string[] $classes */
?>

<li class="{!! implode(' ', $classes) !!}">
	<a href="#">
		@if($element->icon)
			<i class="{{ $element->icon }}"></i>
		@endif
		<span>{{ Lang::get($element->name) }}</span>
		@if($element->hasKids() === true)
			<span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
			@if($element->hasCounter())
				<div class="treeview-menu__label">{{ $element->getCounter() }}</div>
			@endif
		@else
			@if($element->hasCounter())
				<div class="treeview-menu__label">{{ $element->getCounter() }}</div>
			@endif
		@endif
	</a>
	@if($element->hasKids() === true)
		<ul class="treeview-menu">
			@foreach($element->getKids() as $kid)
				{!! Widget::show('aside-element', $kid) !!}
			@endforeach
		</ul>
	@endif
</li>
