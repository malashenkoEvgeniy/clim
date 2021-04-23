@php
/** @var \App\Modules\Products\Models\Product[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator $products */
/** @var string $filter */
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        {!! $filter !!}
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>{{ __('validation.attributes.name') }}</th>
                        <th>{{ __('validation.attributes.vendor_code') }}</th>
                        <th>{{ __('validation.attributes.price') }}</th>
                        <th>{{ __('validation.attributes.available') }}</th>
                        <th>{{ __('validation.attributes.brand_id') }}</th>
                        <th>{{ __('products::general.attributes.categories') }}</th>
                        <th>{{ __('validation.attributes.created_at') }}</th>
                        <th></th>
                    </tr>
                    @foreach($products AS $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{!! $product->vendor_code ?? '&mdash;' !!}</td>
                            <td>{{ $product->formatted_price_for_admin }}</td>
                            <td class="{{ $product->is_available ? 'text-green' : 'text-red' }}">
                                @lang(config('products.availability.' . $product->available))
                            </td>
                            <td>
                                @if($product->group->brand)
                                {!!
                                    Html::link($product->group->brand->link_in_admin_panel, $product->group->brand->current->name, ['target' => '_blank'])
                                !!}
                                @else&mdash;@endif
                            </td>
                            <td>{!! $product->group->print_categories !!}</td>
                            <td>{{ $product->created_at->toDateTimeString() }}</td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.groups.edit', [$product->group_id, 'open' => $product->id]) !!}
                                {!! \App\Components\Buttons::delete('admin.products.destroy', $product->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $products->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
