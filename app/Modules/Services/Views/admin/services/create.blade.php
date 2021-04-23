@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.services.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => 'admin.services.store', 'files' => true]) !!}
    <label for="category">Рубрика</label>
    <select name="rubric_id" id="category">
        @foreach($categories as $category)
        <option value="{{$category->id}}">{{$category->translations[0]->name}}</option>
        @endforeach
    </select>
    <fieldset>
        <legend>Подрубрика</legend>
        <p class="radio-p" style="color: red; background-color: gold; width: 350px; font-size: 20px">Не забудте выбрать подрубрику!!!!</p>
        <div class="radio-blocks">
            <div class="radio-block">
                <label for="i1">Вентиляция</label>
                <input type="radio" id="i1" name="sub_rubric" value="1" checked>
            </div>
            <div class="radio-block">
                <label for="i2">Кондиционирование</label>
                <input type="radio" id="i2" name="sub_rubric" value="2">
            </div>
            <div class="radio-block">
                <label for="i3">Отопление</label>
                <input type="radio" id="i3" name="sub_rubric" value="3">
            </div>
        </div>
    </fieldset>
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
