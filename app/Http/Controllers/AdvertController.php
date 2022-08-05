<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advert;

class AdvertController extends Controller
{
    //
    public function create(Request $request)
    {


        $data = $request->validate([
            'name'    => 'sometimes|string',
            'data'      => 'required|string'
        ]);

        $advert = Advert::create($request->all());
        return response()->json(['advert' => $advert], 200);
    }

    public function index(Request $request)
    {
        return response()->json(['adverts' => Advert::all()], 200);
    }

    public function deleteAd(Request $request, $id)
    {
        return response()->json(['advert' => Advert::where('id', $id)->delete()], 200);
    }
}
