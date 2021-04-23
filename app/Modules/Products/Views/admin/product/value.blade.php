@php
/** @var \App\Modules\Features\Models\FeatureValue $value */
@endphp

<div class="form-group col-md-6">
    <label class="form-label">{{ $value->feature->current->name }}</label>
    <div class="form-control disabled">{{ $value->current->name }}</div>
</div>
