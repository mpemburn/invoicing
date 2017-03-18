<header class="invoice-header">
    <div>
        <h3>Invoice No. {{ $invoice->id }}</h3>
    </div>
    <table width="100%">
        <tr>
            <td>
                <div class="client-address">
                    <div>{{ $client->top_line }}</div>
                    <div>{{ $client->address_1 }}</div>
                    @if (!empty($client->address_2))
                        <div>{{ $client->address_2 }}</div>
                    @endif
                    <div>{{ $client->city_state_zip }}</div>
                    @if (!empty($client->attention))
                        <div class="attn">{{ $client->attention }}</div>
                    @endif
                </div>
            </td>
            <td class="total-container">
                <div class="date-total">
                    <table width="100%" align="right">
                        <tr>
                            <td class="text-right" width="75%">
                                Invoice Date:
                            </td>
                            <td class="text-right" width="25%">
                                {{ $invoice->invoice_date }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" width="75%">
                                Please pay this amount:
                            </td>
                            <td class="text-right" width="25%">
                                {{ $invoice->billed_dollar_amount }}
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</header>
