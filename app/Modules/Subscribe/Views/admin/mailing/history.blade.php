@php
    /** @var \App\Modules\Subscribe\Models\SubscriberMails[] $mails */
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        {!! $filter !!}
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>{{ __('validation.attributes.subject') }}</th>
                        <th>{{ __('subscribe::general.emails-count') }}</th>
                        <th>{{ __('validation.attributes.created_at') }}</th>
                        <th></th>
                    </tr>
                    @foreach($mails AS $mail)
                        <tr>
                            <td>{{ $mail->subject }}</td>
                            <td>{{ $mail->count_emails }}</td>
                            <td>{{ $mail->created_at->toDateTimeString() }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $mails->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
