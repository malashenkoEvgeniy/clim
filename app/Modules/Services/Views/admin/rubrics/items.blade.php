<?php
/**
 *
 *
 * @var \App\Modules\Services\Models\ServicesRubric[] $servicesRubrics
 */
?>

@foreach ($servicesRubrics as $servicesRubric)
    <li class="dd-item dd3-item" data-id="{{ $servicesRubric->id }}">
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
                                       href="{{ route('admin.services_rubrics.edit', ['servicesRubric' => $servicesRubric->id]) }}">
                                        {{ $servicesRubric->current->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td width="30" valign="top" class="icon-column status-column">
                        {!! Widget::active($servicesRubric, 'admin.services_rubrics.active') !!}
                    </td>
                    <td class="nav-column icon-column" valign="top" width="100" align="right">
                        {!! \App\Components\Buttons::edit('admin.services_rubrics.edit', $servicesRubric->id) !!}
                        {!! \App\Components\Buttons::delete('admin.services_rubrics.destroy', $servicesRubric->id) !!}
                    </td>
                </tr>
            </table>
        </div>
    </li>
@endforeach
