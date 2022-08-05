<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use App\Notifications\SavedPage;
use Illuminate\Http\Request;
use App\Models\Visitor;

class VisitorController extends Controller
{
    //
    public function save(Request $request)
    {
        $visitor = Visitor::create($request->all());
        Notification::route('mail', $request->email)->notify(new SavedPage($request->all()));
        return response()->json(['visitor' => $visitor], 200);
    }
}
