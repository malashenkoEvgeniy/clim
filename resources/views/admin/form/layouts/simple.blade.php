@php
/** @var \CustomForm\Builder\Form $form */
/** @var \App\Core\Modules\Languages\Models\Language[] $languages */
/** @var Illuminate\Support\ViewErrorBag $errors */
$buttons = $form->buttons->render();
$languages = config('languages', []);
@endphp

@if($form->showTopButtons)
    {!! $buttons !!}
@endif

@include('admin.form.layouts.form', ['fieldSets' => $form->getFieldSets()])

@if($form->showBottomButtons)
    {!! $buttons !!}
@endif

<div class="clearfix"></div>
