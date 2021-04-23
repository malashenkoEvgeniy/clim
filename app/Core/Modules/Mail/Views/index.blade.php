@php
    /** @var \App\Core\Modules\Mail\Models\MailTemplate[] $templates */
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>{{ __('validation.attributes.name') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($templates AS $template)
                        <tr>
                            <td>@lang($template->name)</td>
                            <td>{!! Widget::active($template, 'admin.mail_templates.active') !!}</td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.mail_templates.edit', $template->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $templates->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
