<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function create(Request $request)
    {
        $publisherUser = $request->all();
        $publisherUser['password'] = Hash::make("12345");
        User::create($publisherUser);
    }

    public function index(Request $request)
    {
        return User::role('publisher')->get();
    }

    public function getPublications(Request $request, $useruuid)
    {
        $publisher = User::with('series')->where('uuid', $useruuid)->firstOrFail();
        return User::find($publisher->id)->series()->paginate(10);
    }

    public function singlePublisher(Request $request, $useruuid)
    {
        $publisher = User::with('series')->where('uuid', $useruuid)->firstOrFail();
        return response()->json(['publisher' => $publisher], 200);
    }

    public function singleUser(Request $request, $useruuid)
    {
        $user = User::where('uuid', $useruuid)->firstOrFail();
        return response()->json(['user' => $user], 200);
    }
}
