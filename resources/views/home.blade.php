@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <client-component></client-component>
        </div>
        {{-- <div class="col-4"> --}}
            {{-- <client-detail-component></client-detail-component> --}}
        {{-- </div> --}}
    </div>
</div>

<div class="container-fluid">
    <div class="card-columns">
        @foreach ($clients as $client)

        <div class="card danger">
            <h5 class="card-header">  </h5>
            <div class="card-body">
                <h5 class="card-title">{{$client->name}} </h5>
                @foreach ($client->tikets as $tiket)

                <p> {{$tiket->amount}} </p>
                @endforeach
                <p class="card-text">additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        @endforeach

    </div>
</div
@endsection


{{-- @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
