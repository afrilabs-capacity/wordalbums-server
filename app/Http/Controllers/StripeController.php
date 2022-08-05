<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

use Session;
use Stripe;
use App\Models\Payment;
use App\Models\User;

class StripeController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        // return $request->all();
        try {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $stripe = Stripe\Charge::create([
                "amount" => $request->book['price'] * 100,
                "currency" => "usd",
                "source" => $request->token['id'],
                "description" =>  $request->product['description']
            ]);

            $user = User::where('uuid', $request->user_uuid)->firstOrFail();

            if ($stripe['status'] == "succeeded") {
                Payment::create([
                    'status' => $stripe['status'],
                    'tnx_id' => $stripe['id'],
                    'book_id' => $request->book['id'],
                    'user_id' => $user->id,
                    'amount' => $stripe['amount']
                ]);
            }


            return response()->json(['user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['data' => null], 500);
        }
        // Session::flash('success', 'Payment successful!');
        // return back();
    }


    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePostDonation(Request $request)
    {
        // return $request->token;
        try {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $stripe = Stripe\Charge::create([
                "amount" => $request->product['amount'] * 100,
                "currency" => "usd",
                "source" => $request->token['id'],
                "description" =>  $request->product['description']
            ]);

            $user = User::where('uuid', $request->user_uuid)->first();

            if ($stripe['status'] == "succeeded") {
                Donation::create([
                    'status' => $stripe['status'],
                    'tnx_id' => $stripe['id'],
                    'book_id' => $request->book['id'],
                    'user_id' => $user ?  $user->id : null,
                    'amount' => $stripe['amount']
                ]);
            }


            return response()->json(['user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
        }
        // Session::flash('success', 'Payment successful!');
        // return back();
    }
}
