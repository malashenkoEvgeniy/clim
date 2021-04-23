@php
    /** @var bool $hasPermission */
    /** @var bool $active */
    /** @var string $url */
@endphp
@if($hasPermission)
    <a href="#" class="label label-{{ $active ? 'success' : 'danger' }} change-status flat" data-url="{{ $url }}">
        <i class="fa {{ $active ? 'fa-check' : 'fa-close' }}"></i>
    </a>
@else
    <span class="label label-{{ $active ? 'success' : 'danger' }} flat disabled-opacity">
        <i class="fa {{ $active ? 'fa-check' : 'fa-close' }}"></i>
    </span>
@endif
