<?php

use Illuminate\Support\Facades\Route;

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
//Public
Route::get('/', [App\Http\Controllers\PublicController::class, 'index']);
Route::get('/peta', [App\Http\Controllers\PublicController::class, 'peta'])->name('home.page');

Auth::routes();

Route::get('/login', [App\Http\Controllers\CustomAuth::class, 'index'])->name('login');
Route::GET('/pengaduan', [App\Http\Controllers\PublicController::class, 'pengaduan'])->name('pengaduan');
Route::GET('/jalan', [App\Http\Controllers\PublicController::class, 'jalan'])->name('jalan');
Route::POST('/validate', [App\Http\Controllers\CustomAuth::class, 'customLogin'])->name('custom.login');

Route::POST('/pengaduan/save', [App\Http\Controllers\PublicController::class, 'store']);
//GET
Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/alternatif', [App\Http\Controllers\AdminController::class, 'alternatif'])->name('admin.alternatif');
Route::get('/admin/kriteria', [App\Http\Controllers\AdminController::class, 'kriteria'])->name('admin.kriteria');
Route::get('/admin/kriteria/subkriteria/get/{id}', [App\Http\Controllers\AdminController::class, 'subkriteria'])->name('admin.sub.kriteria');
Route::get('/admin/nilai/', [App\Http\Controllers\AdminController::class, 'nilai_alternatif'])->name('admin.nilai_alternatif');
Route::get('/admin/rangking/', [App\Http\Controllers\AdminController::class, 'rangking'])->name('admin.rangking');

Route::get('/admin/alternatif/tambah', [App\Http\Controllers\AlternatifController::class, 'baru'])->name('alternatif.baru');
Route::get('/admin/alternatif/edit/{id}', [App\Http\Controllers\AlternatifController::class, 'edit']);

//GET PIMPINAN
Route::GET('/pimpinan/jalan', [App\Http\Controllers\PimpinanAlternatifController::class, 'index'])->name('pimpinan.jalan');
Route::GET('/pimpinan/jalan/lihat/{id}', [App\Http\Controllers\PimpinanAlternatifController::class, 'lihat']);
Route::GET('/pimpinan/pengaduan', [App\Http\Controllers\PimpinanPengaduanController::class, 'index'])->name('pimpinan.pengaduan');
Route::GET('/pimpinan/pengaduan/lihat/{id}', [App\Http\Controllers\PimpinanPengaduanController::class, 'detail']);
Route::GET('/pimpinan/jalan/lihat/{id}/json', [App\Http\Controllers\PimpinanAlternatifController::class, 'json_anggaran']);
Route::GET('/pimpinan/jalan/lihat/{id}/find/{od}', [App\Http\Controllers\PimpinanAlternatifController::class, 'find']);

Route::POST('/pimpinan/jalan/anggaran/update/{id}', [App\Http\Controllers\PimpinanAlternatifController::class, 'update']);
Route::POST('/pimpinan/jalan/anggaran/save', [App\Http\Controllers\PimpinanAlternatifController::class, 'store']);
Route::GET('/pimpinan/jalan/anggaran/delete/{id}', [App\Http\Controllers\PimpinanAlternatifController::class, 'destroy']);
//POST
Route::POST('/admin/alternatif/save', [App\Http\Controllers\AlternatifController::class, 'store']);
Route::POST('/admin/kriteria/save', [App\Http\Controllers\KriteriaController::class, 'store']);
Route::POST('/admin/kriteria/subkriteria/save', [App\Http\Controllers\SubKriteriaController::class, 'store']);
Route::POST('/admin/nilai/save', [App\Http\Controllers\NilaiAlternatifController::class, 'store']);

//UPDATE POST
Route::POST('/admin/alternatif/update/{id}', [App\Http\Controllers\AlternatifController::class, 'update']);
Route::POST('/admin/kriteria/update/{id}', [App\Http\Controllers\KriteriaController::class, 'update']);
Route::POST('/admin/kriteria/subkriteria/update/{id}', [App\Http\Controllers\SubKriteriaController::class, 'update']);
Route::POST('/admin/nilai/update/{id}', [App\Http\Controllers\NilaiAlternatifController::class, 'update']);

//DESTROY
Route::GET('/admin/alternatif/delete/{id}', [App\Http\Controllers\AlternatifController::class, 'destroy']);
Route::GET('/admin/kriteria/delete/{id}', [App\Http\Controllers\KriteriaController::class, 'destroy']);
Route::GET('/admin/kriteria/subkriteria/delete/{id}', [App\Http\Controllers\SubKriteriaController::class, 'destroy']);

//JSON
Route::get('/admin/alternatif/json', [App\Http\Controllers\AlternatifController::class, 'json']);
Route::get('/admin/alternatif/jalan/{id}/json', [App\Http\Controllers\AlternatifController::class, 'json_jalan']);
Route::get('/admin/kriteria/json', [App\Http\Controllers\KriteriaController::class, 'json']);
Route::get('/admin/kriteria/subkriteria/json/{id}', [App\Http\Controllers\SubKriteriaController::class, 'json']);
Route::get('/admin/nilai/json/', [App\Http\Controllers\NilaiAlternatifController::class, 'json']);
Route::get('/admin/rangking/json/', [App\Http\Controllers\RangkingController::class, 'json']);
Route::get('/pimpinan/jalan/json', [App\Http\Controllers\PimpinanAlternatifController::class, 'json']);
Route::get('/pimpinan/pengaduan/json', [App\Http\Controllers\PimpinanPengaduanController::class, 'json']);

//FIND
Route::get('/admin/alternatif/find/{id}', [App\Http\Controllers\AlternatifController::class, 'find']);
Route::get('/admin/kriteria/find/{id}', [App\Http\Controllers\KriteriaController::class, 'find']);
Route::get('/admin/kriteria/subkriteria/find/{id}', [App\Http\Controllers\SubKriteriaController::class, 'find']);
Route::get('/admin/nilai/find/{id}', [App\Http\Controllers\NilaiAlternatifController::class, 'find']);

//ROBOT
Route::get('/admin/robot', [App\Http\Controllers\AdminController::class, 'robot']);
Route::POST('/set_password', [App\Http\Controllers\PublicController::class, 'ganti_password']);
Route::get('/get/jalan/json', [App\Http\Controllers\PublicController::class, 'get_jalan']);
Route::GET('/get/anggaran/{id}/json', [App\Http\Controllers\PublicController::class, 'json_anggaran']);
Route::get('/jalan/json', [App\Http\Controllers\PublicController::class, 'json_jalan']);
Route::get('/jalan/test', [App\Http\Controllers\PublicController::class, 'jalan_test']);
Route::get('/front/nilai/find/{id}', [App\Http\Controllers\PublicController::class, 'find']);
Route::get('/jalan/cordinat/json/{id}', [App\Http\Controllers\PublicController::class, 'find_cordinat']);
