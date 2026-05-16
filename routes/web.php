<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\CarController;

Auth::routes();

Route::get('/language/{locale}', function (string $locale) {
    $selectedLocale = in_array($locale, ['en', 'tr', 'lt'], true) ? $locale : config('app.locale');

    session()->put('locale', $selectedLocale);
    App::setLocale($selectedLocale);

    $previousUrl = url()->previous();

    $redirectResponse = (empty($previousUrl) || $previousUrl === url()->current())
        ? redirect()->route('owners.index')
        : redirect()->to($previousUrl);

    return $redirectResponse->cookie('locale', $selectedLocale, 60 * 24 * 30);
})->name('language.switch');

// Ana sayfa
Route::get('/', function () {
    return redirect()->route('owners.index');
});

Route::middleware('auth')->group(function () {
    Route::resource('owners', OwnerController::class);
    Route::resource('cars', CarController::class);
});
