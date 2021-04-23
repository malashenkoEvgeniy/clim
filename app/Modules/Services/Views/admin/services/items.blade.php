<?php
/**
 *
 *
 * @var \App\Modules\Services\Models\Service[] $services
 */
?>

@foreach ($services as $service)

    <li class="dd-item dd3-item" data-id="{{ $service->id }}">
        <div title="Drag" class="dd-handle dd3-handle">Drag</div>
        <div class="dd3-content">
            <table style="width: 100%;">
                <tr>
                    <td class="column-drag" width="1%"></td>
                    <td valign="top" class="pagename-column">
                        <div class="clearFix">
                            <div class="pull-left">
                                <div class="overflow-20">
                                    <a class="pageLinkEdit"
                                       href="{{ route('admin.services.edit', ['service' => $service->id]) }}">
                                        {{ $service->current->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td width="200">Рубрика: {{$service->category->translations[0]->name}}</td>
                    <td width="30" valign="top" class="icon-column status-column">
                        {!! Widget::active($service, 'admin.services.active') !!}
                    </td>
                    <td class="nav-column icon-column" valign="top" width="100" align="right">
                        {!! \App\Components\Buttons::edit('admin.services.edit', $service->id) !!}
                        {!! \App\Components\Buttons::delete('admin.services.destroy', $service->id) !!}
                    </td>
                </tr>
            </table>
        </div>
    </li>
@endforeach
