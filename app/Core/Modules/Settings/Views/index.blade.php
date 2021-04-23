@php
    /** @var \App\Components\Settings\SettingsGroup[] $groups */
@endphp

@extends('admin.layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ admin_asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ admin_asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ admin_asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $('#dataTable').DataTable({
            'paging'      : false,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : false,
            'autoWidth'   : false,
            'columnDefs': [{
                'targets': 'no-sort',
                'orderable': false,
            }],
            'language'    : {
                'search'  : '{{ __('settings::general.search') }}',
                'emptyTable'  : '{{ __('settings::general.empty-table') }}',
                'processing'  : '{{ __('settings::general.processing') }}',
                'zeroRecords'  : '{{ __('settings::general.zero-records') }}',
            },
        })
    </script>
@endpush

@section('content')
    <section class="buttons-block buttons-block--sticky col-md-12">
        <a class="btn btn-flat btn-m btn-success" href="{{route('admin.settings.clear-cache')}}">
            Сбросить кэш
        </a>
    </section>
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>{{ __('validation.attributes.name') }}</th>
                        <th class="no-sort"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($groups AS $group)
                        <tr>
                            <td>{{ $group->getName() }}</td>
                            <td>
                                @if($group->isNotEmpty())
                                    {{ \App\Components\Buttons::view('admin.settings.show', ['group' => $group->getAlias()]) }}
                                @endif
                                {{ \App\Components\Buttons::edit('admin.settings.group', ['group' => $group->getAlias()]) }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
