<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;


class SubscriptionController extends Controller
{
    //
    public function create(Request $request)
    {


        Subscription::create($request->all());
    }
}
