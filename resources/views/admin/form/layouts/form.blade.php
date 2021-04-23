@foreach($fieldSets as $fieldSet)
    @if($fieldSet instanceof \CustomForm\Builder\FieldSetSimple)
        @include('admin.form.layouts.simple-fieldset', ['fieldSet' => $fieldSet])
    @elseif($fieldSet instanceof \CustomForm\Builder\ViewSet)
        <div class="col-md-{{ $fieldSet->getWidth() }}">
            @include('admin.form.layouts.simple-view', ['fieldSet' => $fieldSet])
        </div>
    @elseif($fieldSet instanceof \CustomForm\Builder\Tabs)
        @include('admin.form.layouts.simple-tabs', ['fieldSet' => $fieldSet])
    @else
        <div class="col-md-{{ $fieldSet->getWidth() }}">
            <div class="{{ $fieldSet->isBoxed() ? 'box' : '' }} {{ $fieldSet->getColor() }}">
                @if($fieldSet instanceof \CustomForm\Builder\FieldSet)
                    @include('admin.form.layouts.simple-no-multilang', ['fieldSet' => $fieldSet])
                @elseif($fieldSet instanceof \CustomForm\Builder\FieldSetLang)
                    @include('admin.form.layouts.simple-multilang', ['fieldSet' => $fieldSet])
                @endif
            </div>
        </div>
    @endif
@endforeach
