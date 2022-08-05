<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;

class RegistrationController extends Controller
{
    //


    public function register(Request $request)
    {
        $requestBody = $request->all();
        $requestBody['password'] = Hash::make($request->password);
        $user =  User::create($requestBody);
        $token = $user->createToken('auth_token')->plainTextToken;
        $readerRole = Role::findOrFail(2);
        $user->assignRole($readerRole);
        return response()
            ->json(['access_token' => $token, 'data' => $user, 'token_type' => 'Bearer',], 200);
    }
}
