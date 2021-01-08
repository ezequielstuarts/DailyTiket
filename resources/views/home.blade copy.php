@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <tiket-detail-modal></tiket-detail-modal>
    <client-component></client-component>
    {{-- <div class="row">
        <div class="col-8">
        </div>
        <div class="col-4"> --}}
            {{-- <client-detail-component :client="client"></client-detail-component> --}}
        {{-- </div>
    </div> --}}
</div>
{{-- <div class="col-12 col-mx-12">
    <div class="card-columns">
        @foreach ($clients as $client)
        <div class="card danger">
            <h5 class="card-header">{{$client->name}}</h5>
            <div class="card-body">
                <h5 class="card-title"></h5>
                <p class="card-text">additional content.</p>
                <a href="{{route('clients', $client->id )}}" class="btn-sm btn-primary text-right">Ver</a>
            </div>
        </div>
        @endforeach
    </div>
</div> --}}


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
