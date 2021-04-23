<?php
/**
 * @var \App\Modules\LabelsForProducts\Models\Label[]|\Illuminate\Support\Collection $labels
 */
?>

@foreach ($labels as $label)
    <li class="dd-item dd3-item" data-id="{{ $label->id }}">
        <div title="Drag" class="dd-handle dd3-handle">Drag</div>
        <div class="dd3-content">
            <table style="width: 100%;">
                <tr>
                    <td class="column-drag" width="1%"></td>
                    <td valign="top" class="pagename-column">
                        <div class="clearFix">
                            <div class="pull-left">
                                <div class="overflow-20">
                                    <a class="pageLinkEdit" href="{{ route('admin.product-labels.edit', [$label->id]) }}" style="color: {{ $label->color }};">
                                        {{ $label->current->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td width="30" valign="top" class="icon-column status-column">
                        {!! Widget::active($label, 'admin.product-labels.active') !!}
                    </td>
                    <td class="nav-column icon-column" valign="top" width="100" align="right">
                        {!! \App\Components\Buttons::edit('admin.product-labels.edit', $label->id) !!}
                        {!! \App\Components\Buttons::delete('admin.product-labels.destroy', $label->id) !!}
                    </td>
                </tr>
            </table>
        </div>
    </li>
@endforeach
