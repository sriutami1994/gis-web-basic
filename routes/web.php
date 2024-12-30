<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController; 
use App\Http\Controllers\MapDataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetaCRUDController;
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

/* UNTUK MENAMBAHKAN DASHBOARD */
Route::get('/', [DashboardController::class, 'index']);


/* HANDS-ON 1: DASAR PETA INTERAKTIF (BASIC MAP INTERACTION) */
# fungsi telah dijelaskan pada hands-on 1
Route::get('/map', [MapController::class, 'index']);


/* HANDS-ON 2: MENAMBAHKAN INTERAKSI MARKER, POLIGON, DAN PENYIMPANAN DATA SPASIAL KE DATABASE PART 1*/
# fungsi telah dijelaskan pada hands-on 2
Route::get('/interactive', [MapDataController::class, 'index'])->name('map.index');
Route::get('/api/markers', [MapDataController::class, 'getMarkers']);
Route::get('/api/polygons', [MapDataController::class, 'getPolygons']);
Route::post('/api/markers', [MapDataController::class, 'storeMarker'])->name('storeMarker');
Route::post('/api/polygons', [MapDataController::class, 'storePolygon'])->name('storePolygon');

/* HANDS-ON 2: MENAMBAHKAN INTERAKSI MARKER, POLIGON, DAN PENYIMPANAN DATA SPASIAL KE DATABASE PART 2*/
# customisasi -> menggunakan template adminlte untuk membuat tampian yang lebih dinamis 
Route::get('/interactiveUp', [MapDataController::class, 'index2'])->name('map.index2');


/*HANDS-ON 3 : */
Route::get('/handson3', [PetaCRUDController::class, 'index'])->name('handson3.index');
Route::get('/listDataMarker', [PetaCRUDController::class, 'getListMarker'])->name('handson3.getListMarker');
Route::get('/listDataPolygon', [PetaCRUDController::class, 'getListPolygon'])->name('handson3.getListPolygon');
Route::post('/storeMarker', [PetaCRUDController::class, 'index'])->name('handson3.storeMarker');
Route::post('/storePolygon', [PetaCRUDController::class, 'index'])->name('handson3.storePolygon');

/*HANDS-ON 4 : */
Route::get('/handson4/viewmaps/{id}', [PetaCRUDController::class, 'viewmaps'])->name('handson4.viewmaps');
Route::get('/handson4/viewleaflet/{id}', [PetaCRUDController::class, 'viewleaflet'])->name('handson4.viewleaflet');
Route::get('/handson4/{id}/edit', [PetaCRUDController::class, 'edit'])->name('handson4.edit');
Route::put('/updateMarker', [PetaCRUDController::class, 'updateMarker'])->name('handson4.updateMarker');





