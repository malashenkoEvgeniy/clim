@php
/** @var \App\Modules\Import\Models\Import|null $import */
$messageClasses = [
    \App\Modules\Import\Models\Import::STATUS_NEW => 'info',
    \App\Modules\Import\Models\Import::STATUS_PROCESSING => 'info',
    \App\Modules\Import\Models\Import::STATUS_DONE => 'success',
    \App\Modules\Import\Models\Import::STATUS_FAILED => 'danger',
];
@endphp

@extends('admin.layouts.main')

@if($import && in_array($import->status, [\App\Modules\Import\Models\Import::STATUS_NEW, \App\Modules\Import\Models\Import::STATUS_PROCESSING]))
    @push('scripts')
        <script>
            let currentStatus = '{{ $import->status }}';
            setInterval(() => {
                $.ajax({
                    url: '{{ route('admin.import.check-status') }}',
                    method: 'GET',
                }).done((data) => {
                    if (data.status !== currentStatus) {
                        window.location.reload();
                    }
                });
            }, 5000);
        </script>
    @endpush
@endif

@section('content-no-row')
    @if($import)
        <div class="callout callout-{{ $messageClasses[$import->status] ?? 'info' }}">
            <h4>Последний импорт</h4>
            @if($import->status === \App\Modules\Import\Models\Import::STATUS_NEW)
                Запущен. Ожидает очереди...
            @elseif($import->status === \App\Modules\Import\Models\Import::STATUS_PROCESSING)
                Запущен. В процессе выполнения...
            @elseif($import->status === \App\Modules\Import\Models\Import::STATUS_DONE)
                Успешно выполнен!
            @else
                Не выполнен или выполнен частично!
            @endif
            @if($import->message)
                <div>{{ $import->message }}</div>
            @endif
        </div>
    @endif
    @if(!$import || $import->isInProcess() === false)
        {!! Form::open(['files' => true]) !!}
            {!! $form->render() !!}
        {!! Form::close() !!}
    @else
        <div class="box">
            <div class="box-body">
                {!!
                    \CustomForm\Select::create('categories')
                        ->add([
                            'none' => 'Ничего не делать',
                            'just-update' => 'Обновить/добавить новые',
                            'update-and-disable-old' => 'Обновить/добавить новые и снять с публикации те, которых нет в прайс-листе',
                        ])
                        ->setLabel('Категории')
                        ->setOptions(['disabled'])
                        ->setDefaultValue(array_get($import->data, 'categories', 'just-update'))
                !!}
                {!!
                    \CustomForm\Select::create('products')
                        ->add([
                            'none' => 'Ничего не делать',
                            'just-update' => 'Обновить/добавить новые',
                            'update-and-disable-old' => 'Обновить/добавить новые и снять с публикации те, которых нет в прайс-листе',
                        ])
                        ->setLabel('Товары')
                        ->setOptions(['disabled'])
                        ->setDefaultValue(array_get($import->data, 'products', 'just-updat'))
                !!}
                {!!
                    \CustomForm\Select::create('images')
                        ->add([
                            'none' => 'Ничего не делать',
                            'rewrite' => 'Удалить старые и загрузить новые',
                            'add' => 'Не удалять старые и догрузить новые',
                        ])
                        ->setOptions(['disabled'])
                        ->setLabel('Изображения')
                        ->setDefaultValue(array_get($import->data, 'images', 'none'))
                !!}
                {!! Widget::show('import::courses-history', $import->currency, array_get($import->data, 'course', [])) !!}
            </div>
        </div>
    @endif
@stop
