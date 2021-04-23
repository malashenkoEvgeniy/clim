@php
/** @var \App\Modules\Users\Models\User $user */
@endphp
<div>{{ $user->name }}</div>
<div><strong>ID</strong>: {{ $user->id }}</div>
@if($user->phone)
    <div><strong>@lang('validation.attributes.phone')</strong>: {{ $user->phone }}</div>
@endif
@if($user->email)
    <div><strong>@lang('validation.attributes.email')</strong>: {{ $user->email }}</div>
@endif