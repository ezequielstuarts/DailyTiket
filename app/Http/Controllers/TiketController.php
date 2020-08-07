<?php

namespace App\Http\Controllers;

use App\Tiket;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function getTikets($id)
    {
        $tikets = Tiket::where('client_id', $id)->orderBy('created_at', 'DESC')->get();
        return response()->json(["tikets" => $tikets]);
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

    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:1|max:99999.99|regex:/^\d*(\.\d{2})?$/',
        ]);
        if (Tiket::create($request->all())) {
            return;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tiket  $tiket
     * @return \Illuminate\Http\Response
     */
    public function show(Tiket $tiket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tiket  $tiket
     * @return \Illuminate\Http\Response
     */
    public function edit(Tiket $tiket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tiket  $tiket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tiket $tiket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tiket  $tiket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tiket = Tiket::find($id);
        if ($tiket->delete()) {
            return response()->json(null, 204);
        }
    }
}
