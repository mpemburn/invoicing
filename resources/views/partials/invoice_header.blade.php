<header class="invoice-header row col-sm-12">
    <div>
        <h3>Invoice No. {{ $invoice->id }}</h3>
    </div>
    <div class="col-sm-4 client-address">
        <div id="edit_client" class="col-sm-push-11 col-sm-1"><i class="fa fa-edit"></i></div>
        <div id="address_block" class="col-sm-12">
            @include('partials/client_header')
        </div>
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

@include('partials/client_select_modal')
