@php
    /** @var \App\Core\Modules\Administrators\Models\Admin $admin */
    /** @var \App\Components\Menu\Link[] $menu */
@endphp
<div class="col-md-3">
    <div class="box box-primary">
        <div class="box-body box-profile">
            {!! $admin->imageTag('small', ['class' => 'profile-user-img img-responsive img-circle'], true) !!}
            <h3 class="profile-username text-center">{{ $admin->first_name }}</h3>
            <ul class="list-group text-bold">
                @foreach($menu as $element)
                    <li class="list-group-item {{ $element->isActive() ? 'active' : null }}">
                        <a href="{{ $element->getUrl() }}">{{ __($element->name) }}</a>
                    </li>
                @endforeach
            </ul>
            <a href="{{ route('admin.logout') }}" class="btn btn-warning btn-block">
                <b>{{ __('auth.logout') }}</b>
            </a>
        </div>
    </div>
</div>
