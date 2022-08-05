<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Advert;
use App\Models\User;

class PageController extends Controller
{
    //
    public function create(Request $request)
    {


        $data = $request->validate([
            'file'  => 'file|mimes:pdf,png,jpeg,jpg',
            'name'    => 'required|string',
            // 'user_id'      => 'required|integer',
            'book_id'      => 'required|integer',
        ]);

        $user = User::where('uuid', $request->user_id)->firstOrFail();
        $data['user_id'] = $user->id;

        $cover_photo_location = $request
            ->file('file')
            ->store('/public/pages');
        $pagesCount = Page::where('book_id', $request->book_id)->count();
        $page = Page::create(array_merge($data, [
            'file' => $cover_photo_location
        ]));


        $pagePosition = $pagesCount + 1;
        Page::where('id', $page->id)->update(['position' => $pagePosition]);


        return response()->json(['page' => $page], 200);
    }

    // public function singlePage(Request $request, $bookId, $seriesId, $userId)
    // {

    //     return response()->json(['series' => Book::where("user_id", $userId)->where("id", $bookId)->first()], 200);
    // }


    public function movePage(Request $request, $pageId, $bookId, $direction)
    {

        if ($direction == "up") {
            $currentPage = Page::where('uuid', $pageId)->first();
            $positionOfAbovePage = Page::where('book_id', $request->bookId)->where('position', '<', $currentPage->position)->orderBy('position', 'desc')->first();
            if ($positionOfAbovePage) {
                // $positionOfAbovePage = Page::where('position', $positionOfAbovePage->position)->first();
                $currentPagePosition = $currentPage->position;
                $positionToSwap = $positionOfAbovePage->position;
                Page::where('uuid', $pageId)->update(['position' => $positionToSwap]);
                Page::where('uuid', $positionOfAbovePage->uuid)->update(['position' => $currentPagePosition]);
            }
            return response()->json([], 200);
        }

        if ($direction == "down") {
            $currentPage = Page::where('uuid', $pageId)->first();
            $positionOfAbovePage = Page::where('book_id', $request->bookId)->where('position', '>', $currentPage->position)->orderBy('position', 'asc')->first();
            if ($positionOfAbovePage) {
                // $positionOfAbovePage = Page::where('position', $positionOfAbovePage->position)->first();
                $currentPagePosition = $currentPage->position;
                $positionToSwap = $positionOfAbovePage->position;
                Page::where('uuid', $pageId)->update(['position' => $positionToSwap]);
                Page::where('uuid', $positionOfAbovePage->uuid)->update(['position' => $currentPagePosition]);
            }

            return response()->json([], 200);
        }
    }

    public function createPageAd(Request $request)
    {
        $advert = Advert::where('uuid', $request->ad_id)->firstOrFail();
        $page = Page::find($request->page);
        $page->adverts()->attach($advert->id);
        return response()->json([], 200);
    }

    public function updatePageAd(Request $request)
    {
        $advert = Advert::where('uuid', $request->ad_id)->firstOrFail();
        $page = Page::find($request->page);
        $existingAd = $page->adverts[0];
        $AdToUpdate = Advert::where('uuid', $request->ad_id)->firstOrFail();
        $page->adverts()->detach($existingAd->id);
        $page->adverts()->attach($AdToUpdate->id);
        return response()->json([], 200);
    }

    public function deletePageAd(Request $request, $id)
    {

        $page = Page::findOrFail($id);
        $advert = Advert::where('uuid', $page->adverts[0]->uuid)->firstOrFail();
        $page->adverts()->detach($advert->id);
        return response()->json([], 200);
    }

    public function canVisitorViewPage(Request $request, $pageuuid, $cookieId)
    {
        $page = Page::where('uuid', $pageuuid)->firstOrFail();
        $shouldShowPage = $page->visitors()->where('cookie_id', $cookieId)->first();
        if ($shouldShowPage) {
            return response()->json(['page' => $page], 200);
        }
        return response()->json([], 403);
    }


    public function deletePage(Request $request, $pageuuid)
    {

        Page::where('uuid', $pageuuid)->delete();
        return response()->json([], 200);
    }
}
