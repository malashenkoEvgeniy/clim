@php
	$specifications = [
	    [
	        'name' => 'Бренд',
	        'value' => 'Locotradeпромпостач'
	    ], [
	        'name' => 'ATC-vet классификационный код',
	        'value' => 'QP53FA - инсектициды; пиретрины, включая синтетические соединения'
	    ], [
	        'name' => 'Регистрационное свидетельство (Украина)',
	        'value' => 'AB-01045-01-10'
	    ], [
	        'name' => 'Регистрация действительна до',
	        'value' => '04.08.2020'
	    ], [
	        'name' => 'Назначение',
	        'value' => 'для овец, для свиней, для кур, для крупного рогатого скота'
	    ], [
	        'name' => 'Вид',
	        'value' => 'раствор'
	    ], [
	        'name' => 'Состав',
	        'value' => '100 мл препарата содержит действующее вещество: дельтаметрин – 5,0 г'
	    ], [
	        'name' => 'Дополнительно',
	        'value' => 'животных обрабатывают на специальных площадках с отстойником или в душевых камерах'
	    ], [
	        'name' => 'Вид упаковки',
	        'value' => 'картон, стекло'
	    ], [
	        'name' => 'Страна-производитель',
	        'value' => 'Украина'
	    ],
	]
@endphp
<div class="title title--size-h3">Основные характеристики препарата Дельтокс</div>
<div class="zebra zebra--odd zebra--light">
    @foreach($specifications as $spec)
        <div class="zebra__line _ptb-md _plr-def _nmlr-def _ms-mlr-none">
            <div class="grid grid--1 _nml-md">
                <div class="gcell gcell--ms-5 gcell--md-4 _pl-md">
                    <strong class="text text--size-13 _color-black"><?= $spec['name']; ?>:</strong>
                </div>
                <div class="gcell gcell--ms-7 gcell--md-8 _pl-md">
                    <span class="text text--size-13 _color-gray6"><?= $spec['value']; ?></span>
                </div>
            </div>
        </div>
    @endforeach
</div>
