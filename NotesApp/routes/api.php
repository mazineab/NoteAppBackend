<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post("/createUser",[UserController::class,"createUser"]);
Route::post("/loginUser",[UserController::class,"loginUser"]);
Route::get("/getUser",[UserController::class,"getUser"])->middleware("auth:sanctum");
Route::post("/logout",[UserController::class,"logout"])->middleware("auth:sanctum");

Route::post("/createCategory",[CategoryController::class,"createCategory"])->middleware("auth:sanctum");
Route::get("/getCategories",[CategoryController::class,"getCategories"])->middleware("auth:sanctum");
Route::delete("/category/{id}",[CategoryController::class,"deleteCategory"])->middleware("auth:sanctum");

Route::post("/createNote",[NoteController::class,"createNote"])->middleware("auth:sanctum");
Route::get("/getNotes",[NoteController::class,"getNotes"])->middleware("auth:sanctum");
Route::delete("/note/{id}",[NoteController::class,"deleteNote"])->middleware("auth:sanctum");