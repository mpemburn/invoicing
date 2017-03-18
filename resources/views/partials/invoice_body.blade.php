<main class="invoice-lineitems">
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
        @foreach ($line_items as $line_item)
            <tr class="{{ $line_item->parity }} {{ $line_item->paid }}" data-count="{{ $line_item->counter }}">
                <td><p>{{ $line_item->item_number }}</p></td>
                <td>{!! $line_item->description_html !!}</td>
                <td class="text-right"><p>{{ $line_item->item_hours }}</p></td>
                <td class="text-right"><p>{{ $line_item->dollar_amount }}</p></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</main>
