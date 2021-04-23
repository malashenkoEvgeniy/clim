@php
/** @var \App\Modules\Users\Models\User $user */
@endphp

<div>
    <strong>[{{ $user->id }}]</strong> {{ $user->name }}
    @if ($user->phone)
        , <i>{{ $user->phone }}</i>
    @endif
    @if ($user->email)
        , <i>{{ $user->email }}</i>
    @endif
</div>