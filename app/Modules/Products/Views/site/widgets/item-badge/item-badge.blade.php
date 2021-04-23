@php
/** @var \App\Modules\LabelsForProducts\Models\Label $label */
@endphp
<div class="item-badge item-badge--default" style="color: {{ $label->color }};">
    <div class="item-badge__text">{{ $label->current->text }}</div>
</div>
