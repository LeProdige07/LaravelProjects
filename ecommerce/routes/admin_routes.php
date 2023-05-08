<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CaterogyController;
use App\Http\Controllers\PdfController;

Route::get('/admin',[AdminController::class,'dashboard'])->middleware(['auth']);


Route::get('/addcategory',[CaterogyController::class,'addcategory']);
Route::get('/categories',[CaterogyController::class,'categories']);
Route::post('/savecategory',[CaterogyController::class,'savecategory']);
Route::get('/editcategory/{id}',[CaterogyController::class,'editcategory']);
Route::post('/updatecategory',[CaterogyController::class,'updatecategory']);
Route::get('/deletecategory/{id}', [CaterogyController::class,'deletecategory']);

Route::get('/addslider',[SliderController::class,'addslider']);
Route::post('saveslider', [SliderController::class,'saveslider']);
Route::get('/sliders',[SliderController::class,'sliders']);
Route::get('/edit_slider/{id}',[SliderController::class,'edit_slider']);
Route::post('updateslider', [SliderController::class,'updateslider']);
Route::get('/delete_slider/{id}',[SliderController::class,'delete_slider']);
Route::get('/activer_slider/{id}', [SliderController::class, 'activer_slider']);
Route::get('/desactiver_slider/{id}', [SliderController::class, 'desactiver_slider']);

Route::get('/addproduct',[ProductController::class,'addproduct']);
Route::get('/products',[ProductController::class,'products']);
Route::post('/saveproduct', [ProductController::class,'saveproduct']);
Route::get('/edit_product/{id}', [ProductController::class,'edit_product']);
Route::post('/updateproduct', [ProductController::class,'updateproduct']);
Route::get('/delete_product/{id}', [ProductController::class, 'delete_product']);
Route::get('/activer_product/{id}', [ProductController::class, 'activer_product']);
Route::get('/desactiver_product/{id}', [ProductController::class, 'desactiver_product']);


Route::get('/voircommandepdf/{id}', [PdfController::class, 'view_pdf']);
