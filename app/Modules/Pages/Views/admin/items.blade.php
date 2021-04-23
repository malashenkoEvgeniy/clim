<?php
/**
 *
 *
 * @var \App\Modules\Pages\Models\Page[] $pages
 */
?>

@foreach ($pages as $page)
    <li class="dd-item dd3-item" data-id="{{ $page->id }}">
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
                                       href="{{ route('admin.pages.edit', ['page' => $page->id]) }}">
                                        {{ $page->current->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td width="30" valign="top" class="icon-column status-column">
                        {!! Widget::active($page, 'admin.pages.active') !!}
                    </td>
                    <td class="nav-column icon-column" valign="top" width="100" align="right">
                        {!! \App\Components\Buttons::edit('admin.pages.edit', $page->id) !!}
                        {!! \App\Components\Buttons::delete('admin.pages.destroy', $page->id) !!}
                    </td>
                </tr>
            </table>
        </div>
        @if($page->children->count() > 0)
            <ol>
                @include('pages::admin.items', ['pages' => $page->children])
            </ol>
        @endif
    </li>
@endforeach
