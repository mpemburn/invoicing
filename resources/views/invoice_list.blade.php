@extends('layouts.app')
@section('content')
    <div class="content">
        <table id="main_invoice_list" class="invoice-list">
            <thead>
            <tr>
                <td>Number</td>
                <td>Name</td>
                <td>Company</td>
                <td>Project</td>
                <td>Inv. Date</td>
                <td>Billed Date</td>
                <td>Outstanding</td>
                <td>Days</td>
                <td>Paid Date</td>
                <td>Hours</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            @foreach ($invoices as $invoice)
                <tr data-id="{{ $invoice->id }}">
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->client->first_name }} {{ $invoice->client->last_name }}</td>
                    <td>{{ $invoice->client->company }}</td>
                    <td>{{ $invoice->project }}</td>
                    <td>{{ Utility::formatMjY($invoice->invoice_date) }}</td>
                    <td>{{ Utility::formatMjY($invoice->billed_date) }}</td>
                    <td class="right {{ $invoice->paid_css }}">{{ $invoice->outstanding_total }}</td>
                    <td></td>
                    <td>{{ Utility::formatMjY($invoice->paid_date) }}</td>
                    <td class="right">{{ $invoice->total_hours }}</td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
        <!-- Push any scripts needed for this page onto the stack -->
@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="{{ URL::to('/js/lib') }}/typeahead.bundle.min.js"></script>
@endpush