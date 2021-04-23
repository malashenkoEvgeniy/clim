@php
/** @var array $courses */
/** @var \App\Modules\Currencies\Components\CurrencyRates\AggregatorAbstraction $nbu */
/** @var \App\Modules\Currencies\Components\CurrencyRates\AggregatorAbstraction $personal */
/** @var string $mainCurrencyCode */
@endphp
<table class="table">
    <thead>
    <tr>
        <th>Название</th>
        <th>Код</th>
        <th>Курс для пересчета цен</th>
    </tr>
    </thead>
    <tbody>
    @foreach($personal->getRates() as $code => $personalCurrency)
        <tr>
            <td>{{ $personalCurrency->getName() }}</td>
            <td>{{ $code }}</td>
            <td>{{ $courses[$code] ?? $personal->convert(1, $code, $mainCurrencyCode) }} {{ $mainCurrencyCode }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
