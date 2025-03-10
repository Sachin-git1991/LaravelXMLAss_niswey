<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\xmlAssController;


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
// Clear application cache:
Route::get('/XmlAss', function() {
    Artisan::call('cache:clear');
});

//Clear route cache:
Route::get('/XmlAss', function() {
Artisan::call('route:cache');
});

//Clear config cache:
Route::get('/XmlAss', function() {
  Artisan::call('config:cache');
}); 

// Clear view cache:
Route::get('/XmlAss', function() {
    Artisan::call('view:clear');
});

Route::redirect('/', '/XmlAss');

Route::get('/XmlAss', [xmlAssController::class, 'index']);
Route::match(["get", "post"], "read-xml", [xmlAssController::class, "xmlUpload"])->name('xml-upload');
Route::get('/XmlAss/edit', [xmlAssController::class, 'edit'])->name('XmlAss.edit');
Route::post('/XmlAss/update', [xmlAssController::class, 'update'])->name('XmlAss.update');
Route::get('/XmlAss/delete', [xmlAssController::class, 'destroy'])->name('XmlAss.delete');


Route::get('/export', [xmlAssController::class, 'export'])->name('xml.export');

