@php
/** @var \App\Modules\Users\Models\User $user */
@endphp

<div class="box box-primary">
    <div class="box-body box-profile">
        <h3 class="profile-username text-center">{{ $user->name }}</h3>
        <p class="text-muted text-center">
            @lang('users::general.registered', ['date' => $user->created_at->format('d.m.Y H:i')])
        </p>
        @if($user->trashed())
            <p class="text-muted text-center">
                @lang('users::general.deleted', ['date' => $user->deleted_at->format('d.m.Y H:i')])
            </p>
        @endif
        <ul class="list-group list-group-unbordered">
            @if($user->phone)
                <li class="list-group-item">
                    <b>@lang('users::general.phone')</b>
                    {{ Html::link("tel:{$user->cleared_phone}", $user->phone, ['class' => 'pull-right']) }}
                </li>
            @endif
            @if($user->email)
                <li class="list-group-item">
                    <b>@lang('users::general.email')</b>
                    {!! Html::mailto($user->email, null, ['class' => 'pull-right']) !!}
                </li>
            @endif
        </ul>
        @if($user->trashed() === false && CustomRoles::can('users.edit'))
            {!! Html::link(
                $user->edit_page_link,
                Html::tag('b', trans('users::general.customer-page')),
                ['class' => ['btn', 'btn-primary', 'btn-block'], 'target' => '_blank'],
                null,
                false
            ) !!}
        @endif
    </div>
</div>
