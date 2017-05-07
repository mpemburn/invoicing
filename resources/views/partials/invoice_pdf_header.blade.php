<header class="invoice-header">
    <div>
@if(!$is_screen)
        <div class="pdf-invoice-number">
            <h3>Invoice No. {{ $invoice->id }}</h3>
        </div>
@endif
        <div class="logo-name">
            <div>
                <img src="{{ URL::to('/') }}/images/pemburnia.png" />
            </div>
            <div>
                <span>Pemburnia Consulting</span>
            </div>
        </div>
        <div class="business-address">
            <div>
                3132B Nova Scotia Road
            </div>
            <div>
                Bel Air, MD 21015
            </div>
            <div>
                (410) 375-5877
            </div>
            <div>
                mark@pemburn.com
            </div>
        </div>
@if($is_screen)
        <h3>Invoice No. {{ $invoice->id }}</h3>
@endif
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
                <div class="date-and-total">
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