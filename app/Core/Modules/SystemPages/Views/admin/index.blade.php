@php
    /** @var \App\Core\Modules\SystemPages\Models\SystemPage[] $systemPages */
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
                        <th>{{ __('global.url') }}</th>
                        <th></th>
                    </tr>
                    @foreach($systemPages AS $systemPage)
                        <tr>
                            <td>{{ $systemPage->current->name }}</td>
                            <td>{{ Html::link($systemPage->url, null, ['target' => '_blank']) }}</td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.system_pages.edit', $systemPage->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@stop
