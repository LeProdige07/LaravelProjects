<?php

use App\Http\Controllers\ClientCustomController;
use App\Http\Controllers\ProductController;

Route::get('/',[ClientCustomController::class,'home']);
Route::get('/shop',[ClientCustomController::class,'shop']);
Route::get('/panier',[ClientCustomController::class,'panier']);
Route::get('/paiement',[ClientCustomController::class,'paiement']);
Route::get('/login',[ClientCustomController::class,'login']);
Route::get('/signup',[ClientCustomController::class,'signup']);
Route::get('/orders',[ClientCustomController::class,'orders']);
Route::get('/ajouteraupanier/{id}', [ClientCustomController::class,'ajouteraupanier']);
Route::post('/modifierqty/{id}',[ClientCustomController::class,'modifierqty']);
Route::get('/deletefromcart/{id}',[ClientCustomController::class,'deletefromcart']);
Route::post('/creercompte', [ClientCustomController::class,'creercompte']);
Route::post('/logincompte', [ClientCustomController::class,'logincompte']);
Route::get('/logout', [ClientCustomController::class,'logout']);
Route::post('/payer', [ClientCustomController::class, 'payer']);
Route::get('/select_by_cat/{category_name}',[ProductController::class,'select_by_cat']);
