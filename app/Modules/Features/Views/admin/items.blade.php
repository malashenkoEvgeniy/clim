<?php
/**
 * @var \App\Modules\Features\Models\Feature[]|\Illuminate\Support\Collection $features
 */
?>

@foreach ($features as $feature)
    <li class="dd-item dd3-item" data-id="{{ $feature->id }}">
        <div title="Drag" class="dd-handle dd3-handle">Drag</div>
        <div class="dd3-content">
            <table style="width: 100%;">
                <tr>
                    <td class="column-drag" width="1%"></td>
                    <td valign="top" class="pagename-column">
                        <div class="clearFix">
                            <div class="pull-left">
                                <div class="overflow-20">
                                    <a class="pageLinkEdit" href="{{ route('admin.features.edit', $feature->id) }}">
                                        {{ $feature->current->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="nav-column icon-column" valign="top" width="100" align="right">
                        {!! \App\Components\Buttons::edit('admin.features.edit', $feature->id) !!}
                        {!! \App\Components\Buttons::delete('admin.features.destroy', $feature->id) !!}
                    </td>
                </tr>
            </table>
        </div>
    </li>
@endforeach
