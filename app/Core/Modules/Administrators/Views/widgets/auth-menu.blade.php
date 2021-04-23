@php
/** @var \App\Components\Menu\Link[] $menu */
/** @var \App\Core\Modules\Administrators\Models\Admin $admin */
@endphp

<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        {!! $admin->imageTag('small', ['class' => 'user-image'], true) !!}
        <span class="hidden-xs">{{ $admin->first_name }}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="user-body nopadding">
            <ul class="menu">
                @foreach($menu as $element)
                    <li><a href="{{ $element->getUrl() }}">{{ __($element->name) }}</a></li>
                @endforeach
            </ul>
        </li>
        <li class="user-footer">
            <div class="pull-right">
                <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">
                    {{ __('auth.logout') }}
                </a>
            </div>
        </li>
    </ul>
</li>
