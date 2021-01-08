@extends('layouts.app')

@section('content')
<div class="col-8 mx-auto">
    <div class="card danger">
        <h5 class="card-header">{{$client->name}}</h5>
        <div class="card-body">
            <h5 class="card-title"></h5>
            @foreach ($client->tikets as $item)
            <p class="card-text">
                {{$item->amount}}
            </p>
            @endforeach
            <a href="{{route('clients', $client->id )}}" class="btn btn-sm btn-primary">Ver</a>
        </div>
    </div>
</div>

@endsection