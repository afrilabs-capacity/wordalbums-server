<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Ramsey\Uuid\Uuid;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // Role::create(['name' => 'publisher']);
    // Role::create(['name' => 'reader']);
    // foreach (App\Models\User::all()  as $user) {
    //     App\Models\User::where('id', $user->id)->update(['uuid' => Uuid::uuid4()]);
    // }
    // $publisher = User::find(8);
    // $publisherRole = Role::findOrFail(3);
    // $publisher->assignRole($publisherRole);
    return view('welcome');
});
