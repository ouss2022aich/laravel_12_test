<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/test', function(Request $request) {
    return response()->json([
        "message" => "Success",
    ]);
});

Route::prefix('posts')->group(function () {

   Route::post('/', [PostController::class, 'store']);
   Route::get('/', [PostController::class, 'index']);
   Route::get('/{id}', [PostController::class, 'show']);
   Route::delete('/{id}', [PostController::class, 'destroy']);
   Route::patch('/{id}', [PostController::class, 'update']);

});
