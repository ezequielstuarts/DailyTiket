<?php

namespace App\Http\Controllers;

use App\Tiket;
use App\Client;
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
        $totalTikets = 0;
        foreach($tikets as $tiket) {
            $totalTikets = $totalTikets+$tiket->amount;
        };
        return response()->json(['tikets' => $tikets, 'totalTikets' => $totalTikets]);
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

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:1|max:99999.99|regex:/^\d*(\.\d{2})?$/',
        ]);
        if(Tiket::find($id)->update($request->all())){
            return;
        }
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

    public function deleteAllTikets($id)
    {
        $client = Client::find($id);
        $tikets = $client->tikets()->delete();
        return response()->json(null, 204);
    }
}
