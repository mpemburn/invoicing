<header class="invoice-header row col-sm-12">
    <div>
        <h3>Invoice No. {{ $invoice->id }}</h3>
    </div>
    <div class="col-sm-4 client-address">
        <div>{{ $client->top_line }}</div>
        <div>{{ $client->address_1 }}</div>
        @if (!empty($client->address_2))
            <div>{{ $client->address_2 }}</div>
        @endif
        <div>{{ $client->city_state_zip }}</div>
        @if (!empty($client->attention))
            <div class="attn">{{ $client->attention }}</div>
        @endif
        @if (!empty($invoice->project))
            <div class="project">Project: {{ $invoice->project }}</div>
        @endif
    </div>
    <div class="col-sm-4 row">
        <div class="col-sm-4 text-right">Invoice Date:</div><div class="col-sm-8 text-bold">{{ $invoice->invoice_date }}</div>
        <div class="col-sm-4 text-right">Date Billed:</div><div class="col-sm-8 text-bold">{{ $invoice->billed_date }}</div>
        <div class="col-sm-4 text-right">Date Paid:</div><div class="col-sm-8 text-bold">{{ $invoice->paid_date }}</div>
    </div>
    <div class="col-sm-4">
        <div class="col-sm-4 text-right">Invoice Total:</div><div class="col-sm-8 text-bold">{{ $invoice->billed_dollar_amount }}</div>
        <div class="col-sm-4 text-right">Total Hours:</div><div class="col-sm-8 text-bold">{{ $invoice->total_hours }}</div>
        <div class="col-sm-4 text-right">Total Paid:</div><div class="col-sm-8 text-bold">{{ $invoice->paid_dollar_amount }}</div>
    </div>
</header>
