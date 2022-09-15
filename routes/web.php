<?php

use App\Http\Controllers\JsonFileController;
use App\Models\JsonData;
use Illuminate\Support\Facades\Route;
// use Datatables;
// use Illuminate\Http\Request;
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
    if (request()->ajax()) {
        $data = JsonData::select('*');
        return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);
    }
    return view('view');
})->name('home');
Route::post('/get-json', [JsonFileController::class, 'getFile'])->name('storeData');
