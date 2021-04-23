@php
/** @var \App\Modules\SlideshowSimple\Models\SlideshowSimple[] $slides */
@endphp

@foreach ($slides as $slide)
    <li class="dd-item dd3-item" data-id="{{ $slide->id }}">
        <div title="Drag" class="dd-handle dd3-handle">Drag</div>
        <div class="dd3-content">
            <table style="width: 100%;">
                <tr>
                    <td class="column-drag" width="1%"></td>
                    <td valign="top" class="pagename-column">
                        <div class="clearFix">
                            <div class="pull-left">
                                <div class="overflow-20">
                                    <a class="pageLinkEdit" href="{{ route('admin.slideshow_simple.edit', ['id' => $slide->id]) }}">
                                        {{ $slide->current->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td width="30" valign="top" class="icon-column status-column">
                        {!! Widget::active($slide, 'admin.slideshow_simple.active') !!}
                    </td>
                    <td class="nav-column icon-column" valign="top" width="100" align="right">
                        {!! \App\Components\Buttons::edit('admin.slideshow_simple.edit', $slide->id) !!}
                        {!! \App\Components\Buttons::delete('admin.slideshow_simple.destroy', $slide->id) !!}
                    </td>
                </tr>
            </table>
        </div>
    </li>
@endforeach
