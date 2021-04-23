@php
    /** @var \CustomForm\Builder\FieldSetLang $fieldSet */
    /** @var \App\Core\Modules\Languages\Models\Language[] $languages */
    $languages = config('languages', []);
@endphp

<div class="nav-tabs-custom {{ $fieldSet->getColor() }}">
    @if($fieldSet->isBoxed() && $fieldSet->getTitle())
        <div class="box-header with-border">
            <h3 class="box-title">{{ __($fieldSet->getTitle()) }}</h3>
        </div>
    @endif
    @if(count($languages) > 1)
        <ul class="nav nav-tabs">
            @foreach($languages AS $language)
                <li class="{{ $language->default ? 'active' : null }}">
                    <a href="#{{ $fieldSet->getUid() . $language->slug }}" data-toggle="tab">
                        {{ $language->name }}
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($fieldSet->getFields() as $languageAlias => $fields)
                @php($language = $languages[$languageAlias])
                <div class="{{ $language->default ? 'active' : null }} tab-pane field-set-with-translit" id="{{ $fieldSet->getUid() . $language->slug }}">
                    @foreach($fields as $field)
                        {!! $field->render() !!}
                    @endforeach
                    <div class="clearfix"></div>
                </div>
            @endforeach
        </div>
    @else
        <div class="{{ $fieldSet->isBoxed() ? 'box-body' : '' }} field-set-with-translit">
            @foreach($fieldSet->getFields() as $languageAlias => $fields)
                @php($language = $languages[$languageAlias])
                @foreach($fields as $field)
                    {!! $field->render() !!}
                @endforeach
            @endforeach
        </div>
    @endif
</div>
<div class="clearfix"></div>
