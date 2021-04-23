@php
$fullName = config('app.name');
$firstLetter = \Illuminate\Support\Str::substr($fullName, 0, 1);
$secondLetter = \Illuminate\Support\Str::substr($fullName, 1, 1);
@endphp
<a href="{{ route('admin.dashboard') }}" class="logo">
    <span class="logo-mini"><b>{{ $firstLetter }}</b>{{ $secondLetter }}</span>
    <span class="logo-lg"><b>{{ $fullName }}</b></span>
</a>
