@if(!empty($warehouses))
    @foreach($warehouses as $warehouse)
        <option value="{{ $warehouse->Ref }}">{{ $warehouse->DescriptionRu }}</option>
    @endforeach
@else
    <option>Ничего не найдено</option>
@endif

