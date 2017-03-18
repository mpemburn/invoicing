@extends('layouts.app')
@section('content')
    <div class="content container">
        @include('partials/invoice_header')
        @include('partials/invoice_body')
    </div>
@endsection
<!-- Push any scripts needed for this page onto the stack -->
@push('scripts')
@endpush