@php
/** @var \App\Modules\Orders\Models\Order $order */
@endphp

@foreach($order->history as $statusChange)
    <tr>
        <td>{{ $statusChange->created_at }}</td>
        <td>
            <span class="label" style="background-color: {{ $statusChange->color }}!important;">
                {{ $statusChange->current->name }}
            </span>
        </td>
        <td>{!! $statusChange->comment ?: '&mdash;' !!}</td>
    </tr>
@endforeach
