<?php



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SezonaController;
use App\Http\Controllers\DogadjajController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
     Route::get('/sezone',[SezonaController::class,'index']);
     Route::get('/sezone/{sezona_id}/rang',[SezonaController::class,'rangListaSezone']);
       Route::get('/dogadjaji',[DogadjajController::class,'index'])->name('dogadjaji.index');

});



