<main class="invoice-lineitems">
    @if($is_screen)
    <header id="lineitems_header" class="text-right">
        <button id="lineitem_add" type="button" class="btn btn-primary">Add Item</button>
    </header>
    @endif
    <div id="lineitems_body">
        <table>
            <thead>
            <tr>
                <td>Item</td>
                <td>Description</td>
                <td class="text-right">Hours</td>
                <td class="text-right">Amount</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($lineitems as $lineitem)
                <tr class="lineitem {{ $lineitem->parity }} {{ $lineitem->paid }}" data-id="{{ $lineitem->id }}" data-count="{{ $lineitem->counter }}">
                    <td><p>{{ $lineitem->item_number }}</p></td>
                    <td>{!! $lineitem->description_html !!}</td>
                    <td class="text-right"><p>{{ $lineitem->item_hours }}</p></td>
                    <td class="text-right"><p>{{ $lineitem->dollar_amount }}</p></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</main>
@if($is_screen)
    @include('partials/lineitem_modal')
@else
    @include('partials/invoice_pdf_footer')
@endif