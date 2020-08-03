<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return view('home', ['clients'=> $clients]);
    }
    public function getClients()
    {
        $clients = Client::orderBy('id', 'DESC')->get();;
        return response()->json(["clients" => $clients]);
        // return view('home', ['clients'=> $clients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:clients,name',
        ]);
        Client::create($request->all());
        return;
    }


    public function getClient($id)
    {
        $client = Client::find($id);
        return response()->json(["client" => $client]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    public function destroy($id)
    {
        $client = Client::find($id);
        if ($client->delete()) {
            return response()->json(null, 204);
        }
        // return response()->json(null, 204);
    }
}
