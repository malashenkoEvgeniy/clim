@php
/** @var \CustomForm\Builder\Form $form */
/** @var Illuminate\Support\ViewErrorBag $errors */

$currentClearUrl = route(Route::currentRouteName(), Route::current()->parameters);
@endphp

{!! Form::open(['method' => 'GET']) !!}

@foreach($form->getFieldSets() as $fieldSet)
	<div class="col-md-{{ $fieldSet->getWidth() }}">
		<div class="box {{ $fieldSet->getColor() }}">
			@if($fieldSet->getTitle())
				<div class="box-header with-border">
					<h3 class="box-title">{{ $fieldSet->getTitle() }}</h3>
				</div>
			@endif
			<div class="box-body">
				@foreach($fieldSet->getFields() as $field)
					{!! $field->render() !!}
				@endforeach
				<div class="col-md-2" style="height: 60px;">
					{!! Form::button(
						Html::tag('i', '', ['class' => 'fa fa-search']),
						[
							'class' => ['btn', 'btn-sm', 'btn-primary', 'btn-flat'],
							'style' => 'margin-top: 25px;',
							'type' => 'submit',
						]
					) !!}
					{!! Html::link(
						$currentClearUrl,
						Html::tag('i', '', ['class' => 'fa fa-refresh']),
						[
							'class' => ['btn', 'btn-sm', 'btn-warning', 'btn-flat'],
							'style' => 'margin-top: 25px;',
							'type' => 'href',
							'data-href' => $currentClearUrl,
						],
						null,
						false
					) !!}
				</div>
			</div>
		</div>
	</div>
@endforeach

<div class="clearfix"></div>

{!! Form::close() !!}
