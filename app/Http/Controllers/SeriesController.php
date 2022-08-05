<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Series;
use App\Models\User;

class SeriesController extends Controller
{
    //

    public function create(Request $request)
    {


        $data = $request->validate([
            'cover_photo'  => 'file|mimes:png,jpeg,jpg',
            'name'    => 'required|string',
            'user_id'      => 'required|integer',
        ]);

        $cover_photo_location = $request
            ->file('cover_photo')
            ->store('/public/photos');

        $series = Series::create(array_merge($data, [
            'cover_photo' => $cover_photo_location
        ]));

        return response()->json(['series' => $series], 200);
    }

    public function singleSeries(Request $request, $seriesId, $useruuid)
    {
        $seriesOwner = User::where('uuid', $useruuid)->firstOrFail();
        return response()->json(['series' => Series::with('books')->where("user_id", $seriesOwner->id)->where("id", $seriesId)->first()], 200);
    }
}
