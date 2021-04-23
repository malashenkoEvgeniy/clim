@php
    /** @var \App\Modules\Products\Models\ProductGroup[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator $groups */
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
                        <th>{{ __('validation.attributes.price') }}</th>
                        <th>{{ __('validation.attributes.brand_id') }}</th>
                        <th>{{ __('products::general.attributes.categories') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($groups AS $group)
                        <tr>
                            <td>{{ $group->name }}</td>
                            <td>{!! $group->relevant_product ? $group->relevant_product->formatted_price_for_admin : '&mdash;' !!}</td>
                            <td>
                                @if($group->brand)
                                {!!
                                    Html::link($group->brand->link_in_admin_panel, $group->brand->current->name, ['target' => '_blank'])
                                !!}
                                @else&mdash;@endif
                            </td>
                            <td>{!! $group->print_categories !!}</td>
                            <td>{!! Widget::active($group) !!}</td>
                            <td>
                                @if(CustomRoles::can('products', 'changeFeature'))
                                    {!!
                                        \App\Components\Buttons::custom(
                                            Html::tag('i', '', ['class' => ['fa', 'fa-exchange']]),
                                            'admin.groups.change-feature',
                                            $group->id,
                                            CustomRoles::can('products.edit'),
                                            'btn-foursquare'
                                        )
                                    !!}
                                @endif
                                {!! \App\Components\Buttons::edit('admin.groups.edit', $group->id) !!}
                                {!! \App\Components\Buttons::custom('', 'admin.groups.clone',$group->id, true, 'fa fa-clone') !!}
                                {!! \App\Components\Buttons::delete('admin.groups.destroy', $group->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $groups->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
