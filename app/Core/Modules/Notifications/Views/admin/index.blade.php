@php
/** @var \App\Core\Modules\Notifications\Models\Notification[] $notifications */
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
                        <th>{{ __('validation.attributes.created_at') }}</th>
                    </tr>
                    @foreach($notifications AS $notification)
                        @php
                            /** @var \App\Core\Modules\Notifications\Types\NotificationType $type */
                            $type = config('notifications.' . $notification->type);
                        @endphp
                        <tr {!! $notification->active !== true ? 'class="no-active" bgcolor="#a9a9a9"' : ''  !!} data-id="{{$notification->id}}">
                            <td>
                                @if($type && $type->getIcon())
                                    <i class="{!! $type->getIcon() !!} {!! $type->getColor() !!}"></i>
                                @endif
                                @if(Route::has($notification->route))
                                    {{ Html::link(
                                        route($notification->route, $notification->parameters),
                                        __($notification->name),
                                        ['target' => '_blank']
                                    ) }}
                                @else
                                    {{ __($notification->name) }}
                                @endif
                            </td>
                            <td>{{ $notification->created_at->toDateTimeString() }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $notifications->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
@push('scripts')
    <script>
        $(window).load(function(){
            $(function(){
                $('table .no-active').each(function(){
                    $(this).animate({ backgroundColor: "white" }, 3000);
                });
            });
        });
    </script>
@endpush
