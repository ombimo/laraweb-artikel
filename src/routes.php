<?php
use Illuminate\Support\Facades\Route;
use Ombimo\LarawebArtikel\Controllers\ArtikelController;
use Ombimo\LarawebArtikel\Controllers\ArtikelIndexController;
use Ombimo\LarawebArtikel\Controllers\ArtikelTagsController;

if (config('laraweb.multilang')) {
    $prefix = '{locale}/' . config('laraweb-artikel.prefix');
} else {
    $prefix = config('laraweb-artikel.prefix');
}

Route::group([
    'prefix' => $prefix,
    'namespace' => 'Ombimo\LarawebArtikel\Controllers',
    'middleware' => 'web'
], function() {
    //artikel index
    Route::get('/', [ArtikelIndexController::class, 'index'])->name('artikel-index');
    Route::get('kategori/{kategoriSlug}', [ArtikelIndexController::class, 'index'])->name('artikel-index.by-kategori');
    Route::get('tags/{tagSlug}', [ArtikelIndexController::class, 'index'])->name('artikel-index.by-tag');
    Route::get('tags', [ArtikelTagsController::class, 'index'])->name('artikel-tags');

    Route::get('detail/{id}/{slug?}', [ArtikelController::class, 'get'])->name('artikel-detail');
});

/*
Route::group([
    'prefix' => 'amp/blog',
    'namespace' => 'Ombimo\LarawebArtikel\Controllers',
    'middleware' => 'web'
], function() {
    Route::get('detail/{id}/{slug?}', 'ArtikelController@detailAmp')->name('blog.detail.amp');
});
*/
