<?php
/**
 * @var \App\Modules\SiteMenu\Models\SiteMenu[] $siteMenus
 * @var int $parentId
 */
?>

@foreach ($siteMenus->get($parentId ?? 0, []) as $siteMenu)
    <li class="dd-item dd3-item" data-id="{{ $siteMenu->id }}">
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
                                       href="{{ route('admin.site_menu.edit', ['id' => $siteMenu->id, 'place' => $siteMenu->place]) }}">
                                        {{ $siteMenu->current->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td width="30" valign="top" class="icon-column status-column">
                        {!! Widget::active($siteMenu, 'admin.site_menu.active') !!}
                    </td>
                    <td class="nav-column icon-column" valign="top" width="100" align="right">
                        {!! \App\Components\Buttons::edit('admin.site_menu.edit', ['id' => $siteMenu->id, 'place' => $siteMenu->place]) !!}
                        {!! \App\Components\Buttons::delete('admin.site_menu.destroy', ['id' => $siteMenu->id, 'place' => $siteMenu->place]) !!}
                    </td>
                </tr>
            </table>
        </div>
        @if(count($siteMenus->get($siteMenu->id, [])) > 0)
            <ol>
                @include('site_menu::admin.items', ['siteMenus' => $siteMenus, 'parentId' => $siteMenu->id])
            </ol>
        @endif
    </li>
@endforeach
