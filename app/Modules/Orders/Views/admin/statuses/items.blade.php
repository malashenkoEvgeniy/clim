<?php
/** @var \App\Modules\Orders\Models\OrderStatus[] $statuses */
?>

@foreach ($statuses as $status)
    <li class="dd-item dd3-item" data-id="{{ $status->id }}">
        <div title="Drag" class="dd-handle dd3-handle">Drag</div>
        <div class="dd3-content">
            <table style="width: 100%;">
                <tr>
                    <td class="column-drag" width="1%"></td>
                    <td valign="top" class="pagename-column">
                        <div class="clearFix">
                            <div class="pull-left">
                                <div class="overflow-20">
                                    <a class="pageLinkEdit" href="{{ route('admin.orders-statuses.edit', [$status->id]) }}" style="color: {{ $status->color }};">
                                        {{ $status->current->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="nav-column icon-column" valign="top" width="100" align="right">
                        {!! \App\Components\Buttons::edit('admin.orders-statuses.edit', $status->id) !!}
                        @if($status->editable)
                            {!! \App\Components\Buttons::delete('admin.orders-statuses.destroy', $status->id) !!}
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </li>
@endforeach
