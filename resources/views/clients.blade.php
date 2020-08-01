<div class="col-12 col-mx-12">
    <div class="card-columns">
        @foreach ($clients as $client)
        <div class="card danger">
            <h5 class="card-header">{{$client->name}}</h5>
            <div class="card-body">
                <h5 class="card-title"></h5>
                <p class="card-text">additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
