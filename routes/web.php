<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $genderCounts = User::selectRaw('gender, COUNT(*) as count')
        ->groupBy('gender')
        ->get();

    $ageCounts = User::selectRaw('age, COUNT(*) as count')
        ->groupBy('age')
        ->orderBy('age')
        ->get();

    return view('welcome', compact('genderCounts', 'ageCounts'));
});
