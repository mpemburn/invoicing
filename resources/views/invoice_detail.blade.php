@extends('layouts.app')
@section('content')
    <div class="content container">
        @include('partials/invoice_header')
        @include('partials/invoice_body')
    </div>
@endsection
<!-- Push any scripts needed for this page onto the stack -->
@push('scripts')
    <script type="text/javascript">
        appSpace.invoiceId = {!! (!is_null($invoice->id)) ? $invoice->id : '0' !!};
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src="{{ URL::to('/js/lib') }}/typeahead.bundle.min.js"></script>
@endpush