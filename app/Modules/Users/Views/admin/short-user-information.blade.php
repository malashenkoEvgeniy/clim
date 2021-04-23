@php
/** @var \App\Modules\Users\Models\User $user */
@endphp

<div>{!! Html::link(route('admin.users.edit', $user->id), "[$user->id] $user->name", ['target' => '_blank']) !!}</div>
@if($user->phone)
    <div>@lang('validation.attributes.phone'): {!! Html::link("tel:$user->cleared_phone", $user->phone) !!}</div>
@endif
@if($user->email)
    <div>@lang('validation.attributes.email'): {!! Html::mailto($user->email) !!}</div>
@endif