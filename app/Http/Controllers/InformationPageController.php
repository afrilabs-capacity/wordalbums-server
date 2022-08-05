<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformationPage;

class InformationPageController extends Controller
{
    //

    public function create(Request $request)
    {
        // return $request->cover_photo == "" ? "true" : "false";
        $data = $request->validate([
            'cover_photo'  => 'nullable|file|mimes:png,jpeg,jpg',
            'release_information'    => 'required|string',
            'page_start'    => 'sometimes|boolean',
            'page_end'    => 'sometimes|boolean',
            'position'    => 'sometimes|integer',
            'book_id'      => 'required|integer',
            'delete_cover_photo'      => 'required|boolean',
            'donation_amount'      => 'sometimes|integer',
        ]);

        if ($request->cover_photo != "") {
            $cover_photo_location = $request
                ->file('cover_photo')
                ->store('/public/background_assets');
            $infoPage = InformationPage::updateOrCreate(
                ['book_id' => $data['book_id']],
                array_merge($data, [
                    'cover_photo' => $cover_photo_location
                ])
            );
        } else {
            $infoPage = InformationPage::updateOrCreate(
                ['book_id' => $data['book_id']],
                !$request->delete_cover_photo ? $request->except(['cover_photo']) : $request->all()
            );
        }





        return response()->json(['series' => $infoPage], 200);
    }
}
