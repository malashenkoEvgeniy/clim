@php
/** @var \App\Core\Modules\Notifications\Models\Notification[] $notifications */
/** @var int $total */
@endphp

<li class="dropdown notifications-menu">
    @if($total > 0)
        <a class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer;">
            <i class="fa fa-bell-o"></i>
            <span class="label label-warning count-notification">{{ $total }}</span>
        </a>
        <ul class="dropdown-menu">
            <li class="header">{!! Lang::choice('notifications::general.new-events', $total, ['total' => $total]) !!}</li>
            <li>
                <ul class="menu">
                    @foreach($notifications AS $notification)
                        @php
                        /** @var \App\Core\Modules\Notifications\Types\NotificationType $type */
                        $type = config('notifications.' . $notification->type);
                        @endphp
                        <li>
                            @if(Route::has($notification->route))
                                <a href="{{ route($notification->route, $notification->parameters) }}" title="{{ __($notification->name) }}">
                                    @if($type && $type->getIcon())
                                        <i class="{!! $type->getIcon() !!} {!! $type->getColor() !!}"></i>
                                    @endif
                                    {{ __($notification->name) }}
                                </a>
                            @else
                                <a title="{{ __($notification->name) }}">
                                @if($type && $type->getIcon())
                                    <i class="{!! $type->getIcon() !!} {!! $type->getColor() !!}"></i>
                                @endif
                                {{ __($notification->name) }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </li>
            <li class="footer"><a href="{{ route('admin.notifications.index') }}">@lang('notifications::general.see-all')</a></li>
        </ul>
    @else
        <a href="{{ route('admin.notifications.index') }}">
            <i class="fa fa-bell-o"></i>
        </a>
    @endif
</li>

