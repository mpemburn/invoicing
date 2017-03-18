@extends('layouts.pdf')
@section('content')
    <div class="content container">
        @include('partials/invoice_pdf_header')
        @include('partials/invoice_body')
    </div>
@endsection
