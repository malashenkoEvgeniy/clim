@php
/** @var \App\Core\Modules\Translates\Models\Translate[] $translates */
/** @var array $languages */
@endphp

@extends('admin.layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ admin_asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ admin_asset('dev/liQuickEdit.css') }}">
@endpush

@push('scripts')
    <script src="{{ admin_asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ admin_asset('dev/jquery.liQuickEdit.js') }}"></script>
    <script src="{{ admin_asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $('#dataTable').DataTable({
            'language': {
                url: '{{ admin_asset('dev/' . Lang::locale() . '.json') }}'
            },
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': false,
            'autoWidth': true,
            'columnDefs': [{
                'targets': 'no-sort',
                'orderable': false,
            }],
            drawCallback: function () {
                $('#dataTable tbody tr').each(function () {
                    $(this).find('td').each(function (i, el) {
                        var lang = $('#dataTable thead tr th:nth-child(' + (i + 1) + ')').data('lang');
                        if (lang) {
                            $(this).addClass('qe');
                            $(this).data('lang', lang);
                        }
                    });
                });
                $('.qe').liQuickEdit({
                    qeOpen: function (el, text) {},
                    qeClose: function (el, text) {
                        $.ajax({
                            url: '{{ route('admin.translates.update', ['place' => $place ?: 'general']) }}',
                            type: 'POST',
                            dataType: 'JSON',
                            data: {
                                key: el.closest('tr').data('key'),
                                value: text,
                                lang: el.data('lang'),
                            }
                        });
                    }
                })
            }
        });
    </script>
@endpush

@section('content-no-row')
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <a href="{{ route('admin.translates.index', ['place' => 'site']) }}" class="col-md-3">
                    <button type="button" class="btn btn-block btn-{{ $place === 'site' ? 'success' : 'primary' }}">
                        {{ __('translates::places.site') }}
                    </button>
                </a>
                <a href="{{route('admin.translates.index', ['place' => 'admin'])}}" class="col-md-3">
                    <button type="button" class="btn btn-block btn-{{ $place === 'admin' ? 'success' : 'primary' }}">
                        {{ __('translates::places.admin') }}
                    </button>
                </a>
                <a href="{{route('admin.translates.index', ['place' => 'general'])}}" class="col-md-3">
                    <button type="button" class="btn btn-block btn-{{ !$place ? 'success' : 'primary' }}">
                        {{ __('translates::places.general') }}
                    </button>
                </a>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body" style="display: block;">
                @foreach($modules AS $module)
                    <a href="{{ route('admin.translates.module', ['place' => $place ?: 'general', 'module' => $module]) }}" class="col-md-2 pad">
                        @php
                            $modelName = $module;
                            if(\Lang::has($modelName . '::general.menu.list')){
                                $modelName = \Lang::get($modelName . '::general.menu.list');
                            }elseif(\Lang::has($modelName . '::general.menu')){
                                $modelName = \Lang::get($modelName . '::general.menu');
                            }
                            $modelName = $modelName === '*' ? __('translates::module.general') : $modelName;
                        @endphp
                        <button type="button" class="btn btn-sm btn-block btn-{{ $currentModule === $module ? 'success' : 'primary' }}">{{ $modelName }}</button>
                    </a>
                @endforeach
                @if(count($modules) > 1)
                    <a href="{{ route('admin.translates.module', ['place' => $place ?: 'general', 'module' => 'all-translates']) }}" class="col-md-2 pad">
                        <button type="button" class="btn btn-sm btn-block btn-{{ $currentModule === 'all-translates' ? 'success' : 'primary' }}">
                            @lang('translates::module.all-translates')
                        </button>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>{{ __('translates::list.keys') }}</th>
                        @foreach($languages AS $slug => $language)
                            @if(count($languages) > 1)
                                <th data-lang="{{ $slug }}">{{ array_get($language, 'name') }}</th>
                            @else
                                <th data-lang="{{ $slug }}">{{ trans('translates::general.translate') }}</th>
                            @endif
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @if($currentModule === 'all-translates')
                        @foreach($allTranslates AS $_module => $_translates)
                            @foreach($_translates AS $_key => $_translate)
                                <tr data-key="{{ $_module === '*' ? $_key : $_module . '::' . $_key }}">
                                    <td>{{ $_module === '*' ? $_key : $_module . '::' . $_key }}</td>
                                    @foreach($languages AS $slug => $language)
                                        <td>{{ array_get($_translate, $slug) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                    @else
                        @foreach($translates AS $key => $translate)
                            <tr data-key="{{ $currentModule === '*' ? $key : $currentModule . '::' . $key }}">
                                <td>{{ $currentModule === '*' ? $key : $currentModule . '::' . $key }}</td>
                                @foreach($languages AS $slug => $language)
                                    <td>{{ array_get($translate, $slug) }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
