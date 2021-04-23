<?php
/**
 * @var \App\Modules\ProductsDictionary\Models\Dictionary[]|null $values
 */
?>
@if(isset($values))
    @foreach ($values as $value)
        @php($editUrl = route('admin.dictionary.edit', ['value' => $value->id]))
        @php($deleteUrl = route('admin.dictionary.destroy', ['value' => $value->id]))
        <li class="dd-item dd3-item" data-id="{{ $value->id }}">
            <div title="Drag" class="dd-handle dd3-handle">Drag</div>
            <div class="dd3-content">
                <table style="width: 100%;">
                    <tr>
                        <td class="column-drag" width="1%"></td>
                        <td valign="top" class="pagename-column">
                            <div class="clearFix">
                                <div class="pull-left">
                                    <div class="overflow-20">
                                        {{ $value->current->name }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        {{--<td width="30" valign="top" class="icon-column status-column">
                            {!! Widget::active($value, 'admin.dictionary.active') !!}
                        </td>--}}
                        <td class="nav-column icon-column" valign="top" width="100" align="right">
                            <button type="button" href="{{ $deleteUrl }}"
                                    class="btn btn-danger btn-xs pull-right ajax-request"
                                    data-confirmation="@lang('products_dictionary::admin.delete-value-warning')">
                                <i class="fa fa-trash-o"></i>
                            </button>
                            <button type="button" href="{{ $editUrl }}"
                                    class="ajax-request btn btn-warning btn-xs pull-right margin-r-5">
                                <i class="fa fa-pencil"></i>
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </li>
    @endforeach
@endif
