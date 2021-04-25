@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.services.index'));
    $url = route('admin.services.update', Route::current()->parameters);
    dd($url);
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['method' => 'PUT', 'url' => $url, 'files' => true]) !!}
    <label for="category">Рубрика</label>
    <select name="rubric_id" id="category">
        @foreach($categories as $category)
            <option value="{{$category->id}}">{{$category->translations[0]->name}}</option>
        @endforeach
    </select>
    <fieldset>
        <legend>Подрубрика</legend>

        <div class="radio-blocks">
            <div class="radio-block">
                <label for="i1">Вентиляция</label>
                <input type="radio" id="i1" name="sub_rubric" value="1" @if($service->sub_rubric==1) checked @endif>
            </div>
            <div class="radio-block">
                <label for="i2">Кондиционирование</label>
                <input type="radio" id="i2" name="sub_rubric" value="2" @if($service->sub_rubric==2) checked @endif>
            </div>
            <div class="radio-block">
                <label for="i3">Отопление</label>
                <input type="radio" id="i3" name="sub_rubric" value="3" @if($service->sub_rubric==3) checked @endif>
            </div>
        </div>
    </fieldset>
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
