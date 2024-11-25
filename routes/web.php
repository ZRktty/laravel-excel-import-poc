<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [DevController::class, 'test']);
Route::get('/categories', [DevController::class, 'getAllCategories']);
Route::get('/append-category', [DevController::class, 'appendToCategory']);

Route::get('/append-tree', [DevController::class, 'createFromTree']);


Route::get('/get-ancestors/{id}', [DevController::class, 'getAncestors']);
//create  route for tree
Route::get('/tree', [DevController::class, 'tree']);

//route to attachCategoryToProduct
Route::get('/attach-category-to-product/{productId}/{categoryId}', [DevController::class, 'attachCategoryToProduct']);

