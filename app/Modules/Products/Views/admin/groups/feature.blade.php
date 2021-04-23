@php
/** @var \App\Modules\Products\Models\ProductGroup $group */
/** @var \App\Modules\Features\Models\Feature $feature */
@endphp

<div class="form-group">
    <label class="form-label">
        @lang('products::admin.main-feature')
        ({!! Html::link(route('admin.groups.change-feature', $group->id), trans('global.change')) !!})
    </label>
    <div class="form-control disabled">{{ $feature->current->name }}</div>
    {!! \CustomForm\Hidden::create('feature_id')->setDefaultValue($feature->id) !!}
</div>
