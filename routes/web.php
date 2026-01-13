<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ThumbnailController;
use Illuminate\Support\Facades\Route;


Route::get( 'storage/images/{dir}/cache/{id}/{method}/{size}/{file}', ThumbnailController::class )
     ->where( 'method', 'resize|crop|fit' )
     ->where( 'size', '\d+x\d+' )
     ->where( 'file', '.+\.(png|jpg|webp|jpeg)' )
     ->name( 'thumbnail' );


Route::get( '/', HomeController::class )->name( 'home' );

Route::get( '/region/{region:slug}', RegionController::class )->name( 'region' );

Route::get( '/object/{product:slug}', [ ProductController::class, 'show' ] )
     ->name( 'products.show' );


Route::get( '/catalog', CatalogController::class )->name( 'catalog' );


Route::get( '/catalog/category/{category:slug}/{city:slug?}', [ CatalogController::class, 'showCategory' ] )
     ->name( 'catalog.category' );

Route::get( '/catalog/city/{city:slug}/{category:slug?}', [ CatalogController::class, 'showCity' ] )
     ->name( 'catalog.city' );


Route::domain( '{region:slug}.' . env( 'APP_URL' ) )->group( function () {
    Route::get( '/catalog', HomeController::class )->name( 's.home' );
    Route::get( '/object/{product:slug}', [ ProductController::class, 'show' ] )
         ->name( 's.products.show' );
} );


Route::get( '/add_item', AnnouncementController::class )
     ->name( 'announcement.index' );


Route::get( '/dashboard', function () {
    return view( 'dashboard' );
} )->middleware( [ 'auth', 'verified' ] )->name( 'dashboard' );

Route::middleware( 'auth' )->group( function () {
    Route::get( '/profile', [ ProfileController::class, 'edit' ] )->name( 'profile.edit' );
    Route::patch( '/profile', [ ProfileController::class, 'update' ] )->name( 'profile.update' );
    Route::delete( '/profile', [ ProfileController::class, 'destroy' ] )->name( 'profile.destroy' );
} );

require __DIR__ . '/auth.php';


/*
|--------------------------------------------------------------------------
| Sitemap Routes
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', [SitemapController::class, 'index'])
    ->name('sitemap.index');

Route::get('/sitemaps/{filename}', [SitemapController::class, 'show'])
    ->where('filename', '[\w\-]+\.xml')
    ->name('sitemap.show');


Route::get( '/{page:slug}', PageController::class )
     ->name( 'page.show' );
