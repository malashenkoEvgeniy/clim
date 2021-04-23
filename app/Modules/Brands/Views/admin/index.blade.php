@php
/** @var \App\Modules\Brands\Models\Brand[] $brands */
/** @var string $filter*/
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        {!! $filter !!}
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>{{ __('validation.attributes.name') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($brands AS $brand)
                        <tr>
                            <td>{{ $brand->current->name }}</td>
                            <td>{!! Widget::active($brand, 'admin.brands.active') !!}</td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.brands.edit', $brand->id) !!}
                                {!! \App\Components\Buttons::delete('admin.brands.destroy', $brand->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $brands->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
