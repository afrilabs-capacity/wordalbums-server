<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;

class BookController extends Controller
{
    //

    public function index()
    {
        return response()->json(['books' => Book::all()], 200);
    }

    public function create(Request $request)
    {


        $data = $request->validate([
            'cover_photo'  => 'file|mimes:png,jpeg,jpg',
            'name'    => 'required|string',
            'price'      => 'sometimes|string',
            'user_id'      => 'required|integer',
            'series_id'      => 'sometimes|integer',
        ]);

        $cover_photo_location = $request
            ->file('cover_photo')
            ->store('/public/photos');

        $book = Book::create(array_merge($data, [
            'cover_photo' => $cover_photo_location
        ]));

        return response()->json(['book' => $book], 200);
    }

    public function singleBook(Request $request, $bookId, $seriesId, $useruuid)
    {

        $owner = User::where('uuid', $useruuid)->firstOrFail();
        return response()->json(['book' => Book::with('pages')->where("user_id", $owner->id)->where("id", $bookId)->first()], 200);
    }

    public function singleBookById($uuid)
    {
        return response()->json(['book' => Book::with('pages')->where('uuid', $uuid)->first()], 200);
    }

    public function updateBook(Request $request)
    {
        // return $request->all();
        $data = $request->validate([
            'cover_photo'  => 'nullable|file|mimes:png,jpeg,jpg',
            'name'    => 'required|string',
            'price'      => 'sometimes|string',
        ]);

        if ($request->cover_photo != "") {
            $cover_photo_location = $request
                ->file('cover_photo')
                ->store('/public/photos');
            $infoPage = Book::where('uuid', $request->uuid)->update(
                array_merge($data, [
                    'cover_photo' => $cover_photo_location
                ])
            );
        } else {
            $infoPage = Book::where('uuid', $request->uuid)->update(
                !$request->delete_cover_photo ? $request->except(['cover_photo']) : $request->all()
            );
        }





        return response()->json(['book' => $infoPage], 200);
    }

    public function deleteBook(Request $request, $uuid)
    {
        $book = Book::where('uuid', $uuid)->first();
        if ($book->pages()->exists()) {
            foreach ($book->pages()->get() as $page) {
                if ($page->adverts()->exists()) {
                    $page->adverts()->delete();
                    $page->delete();
                }
            }
            Book::where('uuid', $uuid)->delete();
        }
        // return $book->pages()->adverts()->get();
    }
}
