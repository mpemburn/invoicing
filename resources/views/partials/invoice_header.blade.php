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
    <div class="col-sm-4 container">
        <form action="{{ $form_action }}">
            <div class="col-sm-12 row" data-datetype="invoice_date">
                <label class="col-sm-5 edit-item text-right">Invoice Date</label>
                <div class="col-sm-7 text-bold">{{ $invoice->invoice_date }}&nbsp;</div>
                <input class="datepicker" type="text" value="{{ $invoice->invoice_date }}">
            </div>
            <div class="col-sm-12 row" data-datetype="billed_date">
                <label class="col-sm-5 edit-item text-right">Date Billed</label>
                <div class="col-sm-7 text-bold">{{ $invoice->billed_date }}&nbsp;</div>
                <input class="datepicker" type="text" value="{{ $invoice->billed_date }}">
            </div>
            <div class="col-sm-12 row" data-datetype="paid_date">
                <label class="col-sm-5 edit-item text-right">Date Paid</label>
                <div class="col-sm-7 text-bold">{{ $invoice->paid_date }}&nbsp;</div>
                <input class="datepicker" type="text" value="{{ $invoice->paid_date }}">
            </div>
        </form>
    </div>
    <div class="col-sm-4">
        <div class="col-sm-12 row">
            <label class="col-sm-5 text-right">Invoice Total</label>
            <div class="col-sm-7 text-bold">{{ $invoice->billed_dollar_amount }}&nbsp;</div>
        </div>
        <div class="col-sm-12 row">
            <label class="col-sm-5 text-right">Total Hours</label>
            <div class="col-sm-7 text-bold">{{ $invoice->total_hours }}&nbsp;</div>
        </div>
        <div class="col-sm-12 row">
            <label class="col-sm-5 text-right">Total Paid</label>
            <div class="col-sm-7 text-bold">{{ $invoice->paid_dollar_amount }}&nbsp;</div>
        </div>
    </div>
</header>

@include('partials/client_select_modal')
