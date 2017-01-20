@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    @if (Auth::check())
                        <div class="panel-heading">Welcome!</div>

                        <div class="panel-body">
                            <h3 class="text-center">Pemburnia Invoicing</h3>
                    @else
                        <div class="panel-heading">Pemburnia Invoicing</div>

                        <div class="panel-body">
                            Please <a href="{{ url('/login') }}">log in</a> to continue.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
