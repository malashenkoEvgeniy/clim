@extends('site._layouts.account')

@section('account-content')
    <div class="account account--profile-edit">
        <div class="grid">
            @php($width = (isset($noRightMenu) && $noRightMenu === true) ? 12 : 8)
            <div class="gcell gcell--12 gcell--def-{{ $width }} _p-lg">
                <div class="grid _nm-lg">
                    @if(isset($title))
                        <div class="gcell gcell--12 _pt-lg _plr-lg _pb-def">
                            @include('site.account._heading', ['title' => $title])
                        </div>
                    @endif
                    @yield('layout-body')
                </div>
            </div>
            @if($width === 8)
                <div class="gcell gcell--4 _p-lg _def-show" style="border-left: 1px solid #f2f2f2">
                    {!! Widget::show('user-account-right-sidebar') !!}
                </div>
            @endif
        </div>
    </div>
@stop