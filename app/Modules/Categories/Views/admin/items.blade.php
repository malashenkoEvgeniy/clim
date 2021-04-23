<?php
/**
 * @var string $parentId
 * @var \App\Modules\Categories\Models\Category[]|\Illuminate\Support\Collection $categories
 */
?>

@foreach ($categories->get($parentId, []) as $category)
    <li class="dd-item dd3-item" data-id="{{ $category->id }}">
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
                                       href="{{ route('admin.categories.edit', ['category' => $category->id]) }}">
                                        {{ $category->current->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td width="30" valign="top" class="icon-column status-column">
                        {!! Widget::active($category, 'admin.categories.active') !!}
                    </td>
                    <td class="nav-column icon-column" valign="top" width="100" align="right">
                        {!! \App\Components\Buttons::edit('admin.categories.edit', $category->id) !!}
                        {!! \App\Components\Buttons::delete('admin.categories.destroy', $category->id) !!}
                    </td>
                </tr>
            </table>
        </div>
        @if(count($categories->get($category->id, [])) > 0)
            <ol>
                @include('categories::admin.items', ['categories' => $categories, 'parentId' => $category->id])
            </ol>
        @endif
    </li>
@endforeach
