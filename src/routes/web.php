<?php
/**
 * Organize routes in a separate file
 */
use App\Controllers\ApiController;
use App\Controllers\SummaryController;
use App\Controllers\UserController;
use \Core\Route;

Route::get("/", "index");
Route::get("/summarize", [SummaryController::class, 'index']);
Route::post("/summarize", [SummaryController::class, 'summarize']);



Route::get("/login", [UserController::class, "login"]);
Route::post("/login", [UserController::class, "login"]);


Route::get("/profile", [UserController::class, "profile"]);
Route::post("/profile", [UserController::class, "editProfile"]);

Route::get("/register", [UserController::class, 'register']);
Route::post("/register", [UserController::class, 'register']);
Route::get("/logout", [UserController::class, 'logout']);

Route::get("/history", [UserController::class, 'history']);

Route::post("/feedback", [SummaryController::class, 'feedback']);

Route::get("/apis", [ApiController::class, 'index']);


