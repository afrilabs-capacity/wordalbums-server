<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdvertController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\InformationPageController;
use App\Http\Controllers\SubscriptionController;

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Credentials', ' true');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegistrationController::class, 'register']);
Route::get('/user/{useruuid}', [UserController::class, 'singleUser']);

Route::post('/publishers', [UserController::class, 'index']);
Route::get('/publisher/{useruuid}', [UserController::class, 'singlePublisher']);
Route::post('/publisher-create', [UserController::class, 'create']);
Route::get('/publisher-publications/{useruuid}', [UserController::class, 'getPublications']);

Route::get('/series', [SeriesController::class, 'index']);
Route::get('/series/{seriesId}/publisher/{useruuid}', [SeriesController::class, 'singleSeries']);
Route::post('/series-create', [SeriesController::class, 'create']);

Route::post('/book-create', [BookController::class, 'create']);
Route::post('/book/update', [BookController::class, 'updateBook']);
Route::delete('/book/delete/{uuid}', [BookController::class, 'deleteBook']);
Route::get('/books', [BookController::class, 'index']);
Route::get('/book/{bookId}', [BookController::class, 'singleBookById']);
Route::get('/book/{bookId}/series/{seriesId}/publisher/{useruuid}', [BookController::class, 'singleBook']);

Route::post('/advert-create', [AdvertController::class, 'create']);
Route::get('/adverts', [AdvertController::class, 'index']);
Route::delete('/advert/delete/{id}', [AdvertController::class, 'deleteAd']);

Route::post('/page-create', [PageController::class, 'create']);
Route::get('/page/{pageuuid}/cookieId/{cookieId}', [PageController::class, 'canVisitorViewPage']);
Route::get('/page/{pageId}/book/{bookId}/move/{direction}', [PageController::class, 'movePage']);
Route::delete('/page/{pageuuid}/delete', [PageController::class, 'deletePage']);
Route::post('/page/advert', [PageController::class, 'createPageAd']);
Route::post('/page/advert/update', [PageController::class, 'updatePageAd']);
Route::delete('/page/advert/delete/{id}', [PageController::class, 'deletePageAd']);

Route::post('/guest/page/save', [VisitorController::class, 'save']);
Route::get('stripe', [StripeController::class, 'stripe']);
Route::post('/stripe/charge', [StripeController::class, 'stripePost'])->name('stripe.post');
Route::post('/stripe/charge/donation', [StripeController::class, 'stripePostDonation'])->name('stripe.post');


Route::post('/information-page/create-or-update', [InformationPageController::class, 'create']);


Route::post('/subscription/create', [SubscriptionController::class, 'create']);
