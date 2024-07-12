<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post("/createUser",[UserController::class,"createUser"]);
Route::post("/loginUser",[UserController::class,"loginUser"]);


Route::post("/logout",[UserController::class,"logout"])->middleware("auth:sanctum");
//create note
Route::post("/createCategory",[CategoryController::class,"createCategory"])->middleware("auth:sanctum");

Route::post("/createNote",[NoteController::class,"createNote"])->middleware("auth:sanctum");
Route::get("/getCategories",[CategoryController::class,"getCategories"])->middleware("auth:sanctum");
Route::get("/getNotes",[NoteController::class,"getNotes"])->middleware("auth:sanctum");