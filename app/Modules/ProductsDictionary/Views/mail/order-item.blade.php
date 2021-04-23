@php
/** @var \App\Modules\ProductsDictionary\Models\Dictionary $dictionary */
@endphp

@if($dictionary)
<tr>
    <td style="vertical-align: middle;" colspan="2">
        {{ $dictionary->getName() }}
    </td>
    <td style="vertical-align: middle;" colspan="2">
        {{ $dictionary->current->name }}
    </td>
</tr>
@endif
