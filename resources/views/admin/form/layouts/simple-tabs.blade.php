@php
/** @var \CustomForm\Builder\Tabs $fieldSet */
@endphp

<div class="nav-tabs-custom main-tabs-block">
    @if($fieldSet->getTabs()->isNotEmpty())
        <ul class="nav nav-tabs">
            @foreach($fieldSet->getTabs() AS $tab)
                <li class="{{ $loop->index === 0 ? 'active' : null }}">
                    <a href="#{{ $tab->getId() }}" data-toggle="tab">
                        {{ $tab->getName() }}
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($fieldSet->getTabs() as $tab)
                <div class="{{ $loop->index === 0 ? 'active' : null }} tab-pane" id="{{ $tab->getId() }}">
                    @include('admin.form.layouts.form', ['fieldSets' => $tab->getFieldSets()])
                    <div class="clearfix"></div>
                </div>
            @endforeach
        </div>
    @else
        <div class="{{ $fieldSet->isBoxed() ? 'box-body' : '' }}">
            @foreach($fieldSet->getTabs() as $tab)
                @include('admin.form.layouts.form', ['fieldSets' => $tab->getFieldSets()])
            @endforeach
        </div>
    @endif
</div>
