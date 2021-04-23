@php
    /** @var \App\Modules\Products\Models\Product[] $offers */
    /** @var \App\Modules\Currencies\Models\Currency[] $currencies */
    /** @var \Carbon\Carbon $date */
echo '<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE yml_catalog SYSTEM "shops.dtd">';
@endphp
<yml_catalog date="{{ $date }}">
    <shop>
        <name>{{config('db.basic.company')}}</name>
        <company>{{config('db.basic.company')}}</company>
        <url>{{ route('site.home')}}</url>
        <platform>Locotrade</platform>
        <agency>Wezom</agency>
        <email>{{ config('db.basic.admin_email') }}</email>
        <currencies>
            @foreach($currencies as $currency)
                <currency id="{{ $currency->microdata }}" rate="{{ $currency->multiplier }}"/>
            @endforeach
        </currencies>
        <categories>
            @foreach($categories as $category)
                {!! Html::tag('category', $category->current->name, [
                    'id' => $category->id,
                    'parentId' => $category->parent_id ?: false,
                ]) !!}
            @endforeach
        </categories>
        <offers>
            @foreach($offers as $offer)
                <offer id="{{ $offer->id }}" type="vendor.model" {!! $offer->group->mainProduct->id === $offer->id ? '' : 'group_id="' . $offer->group->mainProduct->id . '"' !!}>
                    @if($offer->brand_id)
                        <vendor>{{ $offer->brand->current->name }}</vendor>
                    @endif
                    <model>{{ $offer->current->hidden_name }}</model>
                    <url>{{ $offer->site_link }}</url>
                    <price>{{ $offer->price_for_site }}</price>
                    @if($offer->old_price)
                        <oldprice>{{ $offer->old_price_for_site }}</oldprice>
                    @endif
                    <currencyId>{{ Catalog::currency()->microdataName() }}</currencyId>
                    <categoryId>{{ $offer->group->category_id }}</categoryId>
                    @foreach($offer->images as $image)
                        @if($image->isImageExists())
                            <picture>{{ $image->link('medium') }}</picture>
                        @endif
                    @endforeach
                    <description>
                        <![CDATA[
                        {!! $offer->group->current->text !!}
                        ]]>
                    </description>
                    @if($offer->value_id)
                        <param name="{{ $offer->value->feature->current->name }}">{{ $offer->value->current->name }}</param>
                    @endif
                    @foreach($offer->feature_values as $param)
                        <param name="{{ $param->feature->current->name }}">{{ $param->value->current->name }}</param>
                    @endforeach
                    <sales_notes></sales_notes>
                </offer>
            @endforeach
        </offers>
    </shop>
</yml_catalog>
